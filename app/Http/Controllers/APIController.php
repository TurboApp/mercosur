<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Coordinacion;
use App\Servicio;
use App\Agente;
use App\Cliente;
use App\LineasTransporte as Transporte;
use App\User;
use App\supervisor_activo;
use App\ManiobraTarea;
use App\ManiobraSubtarea;
use App\Notification;

use App\Events\notificaciones;
use App\Events\ManiobraInicio;

use DB;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use DataTables;

class APIController extends Controller
{
    public function auth()
    {
        $usuario =User::find(auth()->user()->id);
        return $usuario->toJson();
    }
    public function coordinacion(Request $request)
    {
        
        if(auth()->user()->perfil->perfil !== 'coordinador')
        {
            return redirect('/');
        }

        $fecha = Carbon::today()->format('Y-m-d');
        $fechas = explode("*",$request->date);
                
        if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
            $data = Coordinacion::whereBetween("fecha_servicio", [$fechaInicio, $fechaFinal])
                    ->orderBy('fecha_servicio')
                    ->with(['servicio.cliente','supervisor','coordinador'])
                    ->whereHas('servicio.autor', function($q){
                        $q->where('equipo_id', auth()->user()->equipo_id);
                    })    
                    ->get();
        }
        else if( $request->date )
        {
            $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
            $data=Coordinacion::whereDate("fecha_servicio", $fecha)->with(['servicio.cliente','supervisor','coordinador'])
                ->whereHas('servicio.autor', function($q){
                    $q->where('equipo_id', auth()->user()->equipo_id);
                })
                ->get();
        }else{
            $data=Coordinacion::whereDate("fecha_servicio", $fecha)->with(['servicio.cliente','supervisor','coordinador'])
                ->whereHas('servicio.autor', function($q){
                    $q->where('equipo_id', auth()->user()->equipo_id);
                })
                ->get();

        }
        
        foreach($data as $item){
            $date_humans=Date::instance($item->servicio->fecha_recepcion)->format('l j \\d\\e F \\d\\e Y');
            $item->servicio['date_humans'] = $date_humans;
        }
        
        return DataTables::of($data)->toJson();
    }

    public function maniobrasSupervisor(Request $request)
    {
        
        if(auth()->user()->perfil->perfil !== 'supervisor')
        {
            return redirect('/');
        }

        $id = auth()->user()->id;
        
        $fecha=Carbon::today()->format('Y-m-d');
        $fechas=explode("*",$request->date);
        if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
            
            //$servicios = Servicio::whereBetween("fecha_recepcion", [$fechaInicio,$fechaFinal])->get();

            $data = Coordinacion::whereBetween("fecha_servicio", [$fechaInicio,$fechaFinal])
            ->orderBy('fecha_servicio')
            ->where('supervisor_id',$id)
            ->with(['servicio.cliente','supervisor','coordinador'])
            ->get();
        }
        else if( $request->date )
        {
            $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
            
            $data=Coordinacion::whereDate("fecha_servicio", $fecha)->where('supervisor_id',$id)->with(['servicio.cliente','supervisor','coordinador'])->get();
        }else{
            
            $data=Coordinacion::whereDate("fecha_servicio", $fecha)->where('supervisor_id',$id)->with(['servicio.cliente','supervisor','coordinador'])->get();
        }

       
        foreach($data as $item){
            $date_humans=Date::instance($item->servicio->fecha_recepcion)->format('F j, Y');
            $item->servicio['date_humans'] = $date_humans;
        }
        



        return DataTables::of($data)->toJson();
    }


    public function almacen(Request $request)
    {
        
        if(auth()->user()->perfil->perfil !== 'trafico')
        {
            return redirect('/');
        }

        $fecha=Carbon::today()->format('Y-m-d');
        $fechas=explode("*",$request->date);

        if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
            $servicios = Servicio::whereBetween("fecha_recepcion", [$fechaInicio, $fechaFinal])
                ->whereHas('documentos', function($q){
                        $q->where([['status','>','0'],['user_id', auth()->user()->id]]);
                })->get();
        }
        else if( $request->date )
        {
            $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
            $servicios = Servicio::where("fecha_recepcion", $fecha)->whereHas('documentos', function($q){
                $q->where([['status','>','0'],['user_id', auth()->user()->id]]);
            })->get();
        }else{
            $servicios = Servicio::where("fecha_recepcion", $fecha)->whereHas('documentos', function($q){
                $q->where([['status','>','0'],['user_id', auth()->user()->id]]);
            })->get();
        }
        
        foreach($servicios as $servicio){
            $servicio->cliente;
            $servicio->documentos->each(function($item, $key) {
                if( !$item->status ){
                    $item['nombre'] = $item->tipo_documento."-".$item->num_documento . '*';
                }else{
                    $item['nombre'] = $item->tipo_documento."-".$item->num_documento;
                }
            });
            $servicio['fecha'] = strtoupper(Date::instance($servicio->fecha_recepcion)->format('d/M/Y'));
        }

        return DataTables::of($servicios)->toJson();
    }

    public function almacenItem(Request $request )
    {
        $servicio = Servicio::find($request->servicio);
        $servicio->cliente;
        $servicio->agente;
        $servicio->documentos;
        return $servicio->toJson();
    }
    public function coordinacionServicio(Request $request)
    {
        $data = Coordinacion::find($request->id);
        $data->servicio->cliente;
        $data->servicio->agente; 
        $data->servicio->archivos;
        $data->servicio->documentos;
        $data->servicio->transportes;
        foreach ($data->servicio->transportes as $transporte) {
            $lineaTransporte=Transporte::find($transporte->linea_transporte_id);
            $transporte['lineaTransporte'] = $lineaTransporte->nombre;
        }
        
        return $data->toJson();
    }

    public function servicios(Request $request)
    {
        $fecha=Carbon::today()->format('Y-m-d');
        $fechas=explode("*",$request->date);
        if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
            $servicios = Servicio::whereBetween("fecha_recepcion", [$fechaInicio,$fechaFinal])
                        ->where('user_id', auth()->user()->id)->get();
        }
        else if( $request->date )
        {
            $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
            $servicios=Servicio::where([
                    ["fecha_recepcion", $fecha],
                    ["user_id", auth()->user()->id]
                ])->get();
        }
        else
        {
            $servicios=Servicio::where([
                    ["fecha_recepcion", $fecha],
                    ["user_id", auth()->user()->id]
                ])->get();
        }
        foreach($servicios as $servicio){
            $servicio->cliente;
            //$servicio->agente;
            $servicio->documentos;
            $servicio->coordinacion;
            $servicio->transportes;
            
            foreach($servicio->transportes as $transporte){
                $transporte->transporte;
            }

            $date_humans=Date::instance($servicio->fecha_recepcion)->format('F j, Y');
            $servicio['date_humans'] = $date_humans;
        }

        return DataTables::of($servicios)->toJson();
    }

    public function agentes(Request $request)
    {
        if($request->s){
            $agentes = Agente::where('nombre', 'LIKE','%'.$request->s.'%')->orWhere('nombre_corto', 'LIKE','%'.$request->s.'%');
        }else{
            $agentes = Agente::get();
        }
        return DataTables::of($agentes)->toJson();
        //return $agentes->toJson();;
    }
    public function clientes(Request $request)
    {
        if($request->s){
            //$clientes = Cliente::where('nombre', 'LIKE','%'.$request->s.'%')->orWhere('nombre_corto', 'LIKE','%'.$request->s.'%');
            $clientes = Cliente::where(DB::raw("CONCAT(nombre,' ',nombre_corto)"), "LIKE","%$request->s%");
            
        }else{

            $clientes = Cliente::get();
        }
        return DataTables::of($clientes)->toJson();
        
    }
    public function transportes(Request $request)
    {
        if($request->s){
            $transportes = Transporte::where('nombre', 'LIKE','%'.$request->s.'%')->orWhere('nombre_corto', 'LIKE','%'.$request->s.'%');
        }else{
            $transportes = Transporte::get();
        }
        return DataTables::of($transportes)->toJson();
    }

    public function supervisor(Request $request)
    {
        $supervisor = User::find($request->id); 
        return $supervisor->toJson();
    }

    public function supervisores(Request $request)
    {
        if($request->s)
        {
            $supervisores = User::where([
                    ['perfil_id', '6'],
                    ['equipo_id', auth()->user()->equipo_id],
                    ['nombre', 'LIKE','%'.$request->s.'%']
                ])
                ->orWhere([
                    ['perfil_id', '6'],
                    ['equipo_id', auth()->user()->equipo_id],
                    ['apellido', 'LIKE','%'.$request->s.'%']
                ])->get();
        }
        else 
        {
            $supervisores = User::where([
                ['perfil_id', '6'],
                ['equipo_id', auth()->user()->equipo_id]
            ])->get();
        }
        $activos = supervisor_activo::all();
        $inActivos = collect();
        foreach($supervisores as $supervisor)
        {
            $is = $activos->whereIn( 'supervisor_id' , $supervisor->id );
            if($is->isEmpty()){
               $inActivos->push($supervisor);
            }
        }
        
        return $inActivos->toJson();
    }


    public function agregarSupervisor(Request $request, Coordinacion $coordinacion)
    {
        //return $coordinacion->servicio->cliente->toJson();
        $coordinacion->supervisor_id = $request->supervisor;
        $coordinacion->coordinador_id = auth()->user()->id;
        $coordinacion->status='Asignado';
        $coordinacion->save();
        $supervisor = Supervisor_activo::create([
            'supervisor_id'  => $request->supervisor,
            'coordinacion_id' => $coordinacion->id,
            'is_active'      => '1'
        ]);
        
        $notifi = Notification::create([
            'emisor_id' => $coordinacion->coordinador_id, 
            'receptor_id' => $coordinacion->supervisor_id,
            'titulo' => 'Se le asigno un nuevo servicio',
            'mensaje' => 'Servicio '.  $coordinacion->servicio->tipo . '. Num. ' . $coordinacion->servicio->numero_servicio.', cliente ' . $coordinacion->servicio->cliente->nombre,
            'url_icon' => '/img/pushIcon/settings.png',
            'url' => '/maniobras'
        ]);
        event(new notificaciones($notifi));
        event(new ManiobraInicio($notifi));

        return $coordinacion->toJson();
    }
    


    public function infoUser(User $user)
    {
        return $user->toJson();
    }


   
    public function getTareas(Request $request){
        $tareas = ManiobraTarea::where('coordinacion_id',$request->id)->get();
        return $tareas->toJson();
    }

    public function getSubTareas(Request $request){
        $tareas = ManiobraSubtarea::where('tarea_id',$request->id)->get();
        return $tareas->toJson();
    }


}
