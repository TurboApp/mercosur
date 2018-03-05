<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Coordinacion;
use App\ManiobraTarea  as Tareas;
use App\supervisor_activo;
use App\LineasTransporte as Transporte;
use App\ProduccionOperarios;
use App\FuerzaTarea;

use App\Events\ManiobraUpdate;
use App\Events\ManiobraInicio;
use App\Events\ManiobraFin;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use DataTables;


class CoordinacionController extends Controller
{
    function __construct(){
        $this->middleware(['auth','perfils:admin,trafico,supervisor,coordinador,go']);
    }

    public function index()
    {
        $data = Date::instance(Carbon::now());
        return view('pages.coordinacion.index', compact('data'));
    }

    public function indexDatatable(Request $request)
    {
        $fecha = Carbon::today()->format('Y-m-d');
        $fechas = explode("*",$request->date);
                
        if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
            $data = Coordinacion::whereBetween("fecha_servicio", [$fechaInicio,$fechaFinal])
                    ->orderBy('fecha_servicio')
                    ->with(['servicio.cliente','supervisor','coordinador'])
                    ->get();
        }
        else if( $request->date )
        {
            $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
            $data=Coordinacion::whereDate("fecha_servicio", $fecha)->with(['servicio.cliente','supervisor','coordinador'])->get();
        }else{
            $data=Coordinacion::whereDate("fecha_servicio", $fecha)->with(['servicio.cliente','supervisor','coordinador'])->get();
        }
        
        foreach($data as $item){
            $date_humans=Date::instance(Carbon::createFromFormat('Y-m-d',$item->servicio['fecha_recepcion']))->format('l j \\d\\e F \\d\\e Y');
            $item->servicio['date_humans'] = $date_humans;
        }
        
        return DataTables::of($data)->toJson();
    }

    ## COORDINACION ##

    public function maniobra(Request $request, $servicio)
    {
        $coordinacion = Coordinacion::find($servicio);
        $coordinacion->servicio->cliente;
        $coordinacion->servicio->agente;
        $coordinacion->servicio->archivos;
        $coordinacion->servicio->documentos;
        $coordinacion->servicio->transportes;
        $coordinacion->servicio->autor;

        foreach ($coordinacion->servicio->transportes as $transporte) {
            $lineaTransporte=Transporte::find($transporte->linea_transporte_id);
            $transporte['lineaTransporte'] = $lineaTransporte->nombre;
        }
        if($servicio===null){
            $request->session()->flash('danger', 'No se encontro ningun dato');
            return back();
        }else{
            if(auth()->user()->perfil->perfil == 'coordinador'){
                $supervisores = Coordinacion::where([
                                    ['coordinador_id',auth()->user()->id],
                                    ['supervisor_id','!=','Null'],
                                    ['status','!=','Finalizado']
                                ])->with(['supervisor','tareas'])->get();
                
                return view('pages.coordinacion.master', compact('coordinacion', 'supervisores'));
            }else{
                return view('pages.servicios.detalles', compact('coordinacion'));
            }
        }
    }

    public function indexManiobra()
    {
        $data = Date::instance(Carbon::now());
        return view('pages.maniobras.index', compact('data'));
    }

    public function maniobraTareas(Coordinacion $coordinacion, Request $request)
    {
        
        //if( auth()->user()->id !== $coordinacion->coordinador_id && auth()->user()->id !== $coordinacion->supervisor_id )
        if( auth()->user()->id !== $coordinacion->supervisor_id )
        {
            $request->session()->flash('warning', 'Acceso denegado');
            return back();
        }
        $coordinacion->servicio->cliente;
        $coordinacion->servicio->agente;
        $coordinacion->servicio->archivos;
        $coordinacion->servicio->documentos;
        $coordinacion->servicio->transportes;
        foreach ($coordinacion->servicio->transportes as $transporte) {
            $lineaTransporte=Transporte::find($transporte->linea_transporte_id);
            $transporte['lineaTransporte'] = $lineaTransporte->nombre;
        }
        $tareas = Tareas::where('coordinacion_id',$coordinacion->id)->with('subTareas')->get();

        
        if($coordinacion->servicio->tipo == "Carga"){
            $servicioDescarga = $coordinacion->servicio->parent;
            $tareaProcesomaniobra = $servicioDescarga->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
            $ubicacionMercancia = $tareaProcesomaniobra->subtareas->where('subtarea','Capture las fotos donde fue ubicada la mercancia')->first();
            $coordinacion->ubicacion = collect();
            foreach($ubicacionMercancia->attachment as $imagen){
                $coordinacion->ubicacion->push($imagen->url);
            }
        }
        
        return view('pages.maniobras.tareas', compact('coordinacion', 'tareas'));
    }

    public function maniobraInicio(Request $request)
    {
        $maniobra = Coordinacion::where('servicio_id',$request->servicio)->first();
        if (!$maniobra->inicio_maniobra) {
            $now = Carbon::now();
            $maniobra->inicio_maniobra = $now; 
            $maniobra->status='En proceso';
            $maniobra->save();
            event(new ManiobraInicio($maniobra));
        }       
        
        return $maniobra->toJson();
    }
    public function maniobraFin(Request $request)
    {
        $maniobra = Coordinacion::where( 'servicio_id' , $request->servicio )->first();
        if (!$maniobra->termino_maniobra) {
            $now = Carbon::now();
            $maniobra->termino_maniobra = $now; 
            $maniobra->status='Finalizado';
            $maniobra->avance_total =  '100'; 
            $maniobra->indice_activo = '6';
            $maniobra->save();
            
            $supervisor = Supervisor_activo::where([
                ['supervisor_id' , $maniobra->supervisor_id],
                ['coordinacion_id' , $maniobra->id]
            ])->first();
            
            $supervisor->delete();
            
            event(new ManiobraFin($maniobra));
            event(new ManiobraUpdate($maniobra));
            foreach($maniobra->tareas as $tarea){
                if(empty($tarea->inicio)){
                    $tarea->inicio = $tarea->created_at;
                    $tarea->save();
                }
                if(empty($tarea->final)){
                    $tarea->final = $tarea->updated_at;
                    $tarea->save();
                }
            }
        }
        return $maniobra->toJson();
    }

    public function updateAvanceManiobra(Request $request)
    {
        $coordinacion = Coordinacion::find($request->maniobra);   
        if($request->avance > $coordinacion->avance_total){ 
            $coordinacion->avance_total =  $request->avance; 
            $coordinacion->indice_activo = $request->activeIndex;
            $coordinacion->save();
            event(new ManiobraUpdate($coordinacion));
        }
        return $coordinacion->toJson();
    }
    
    public function procesoManiobra(Request $request){
        $tareaId = $request->tarea; 
        $index = $request->index;
        $now = Carbon::now();
        $coordinacion = Coordinacion::where( 'servicio_id' , $request->servicio )->first();
        $tareas = $coordinacion->tareas;
        
        $tarea  = $tareas->where('id',$tareaId)->first();
        $avance = $tarea->avance;
        
        switch($index){
            case 0: //Tarea 1: Revisión
            case 1: //Tarea 2: Anexos Fotograficos
            case 2: //Tarea 3: Validación
            case 3: //Tarea 4: Seleccionar Fuerza de tarea 
            case 4: //Tarea 5: Proceso de maniobra y activacion de fuera de tarea
                
                /** Verifica si el avance de la tarea es mayor o igual al del avance total de la maniobra
                *   Si es asi entonces procede con lo siguiente
                */ 

                if( $avance >= $coordinacion->avance_total )
                { 
                    //Avance
                    /** Actualiza el avance y el indice activo */
                    $coordinacion->avance_total =  $avance; 
                    $coordinacion->indice_activo = $index;
                    
                    //Inicio de tarea - si el registro inicio esta vacio
                    if( !$tarea->inicio )
                    {
                        $tarea->inicio = $now;  //Actualiza la tarea de inicio
                        $tarea->status ='en proceso'; //Actualiza el status de la tarea
                    }

                    //Fin de tarea - si el registro fin esta vacio
                    /** Este proceso se ejecuta si el indice es mayor de cero, el indice cero contiene
                     *  la primer tarea de la maniobra
                      */
                    if( $index > 0 )
                    { 
                        
                        $prevTarea = $tareas->where('id', ( $tareaId - 1 ) )->first();
                        if(!$prevTarea->final)
                        {
                            $prevTarea->final = $now; 
                            $prevTarea->status ='finalizado';
                            $prevTarea->save();
                        }
                    }

                    if( $index === 4 )
                    {
                        //Activar Fuerza de tarea
                        $produccion = ProduccionOperarios::where('coordinacion_id', $coordinacion->id )->get();
                        if(!$produccion->isEmpty())
                        {
                            foreach($produccion as $p)
                            {
                                if(!$p->inicio) // si el registro incio esta vacio
                                { 
                                    $p->inicio = $now;
                                    $p->save();
                                } 
                            }
                        }
                    }
                }
            break;
            case 5: // Tarea 6: Validacion de maniobra
                
                if($avance >= $coordinacion->avance_total){ 
                    //Avance
                    $coordinacion->avance_total =  $avance; 
                    $coordinacion->indice_activo = $index;
                    
                    //Inicio de tarea
                    if(!$tarea->inicio){
                        $tarea->inicio = $now; 
                        $tarea->status ='en proceso';
                    }
                }

            break;
            case 6: // Tarea 7: Finalización
                if($avance >= $coordinacion->avance_total){
                    //this.avanceUpdate(6,95),
                    //Avance
                    $coordinacion->avance_total =  $avance; 
                    $coordinacion->indice_activo = $index;
                    
                    //Inicio de tarea
                    if(!$tarea->inicio){
                        $tarea->inicio = $now; 
                        $tarea->status ='en proceso';
                    }

                
                    //Fin de tarea
                    $prevTarea = $tareas->where('id', ( $tareaId - 1 ) )->first();
                    if(!$prevTarea->final){
                        $prevTarea->final = $now; 
                        $prevTarea->status ='finalizado';
                        $prevTarea->save();
                    }
                    
                    $prevTarea2 = $tareas->where('id', ( $tareaId - 2 ) )->first();
                    if(!$prevTarea2->final){
                        $prevTarea2->final = $now; 
                        $prevTarea2->status ='finalizado';
                        $prevTarea2->save();
                    }
                    
                    /**
                     * Proceso de liberacion de operarios
                     */
                    $produccion = ProduccionOperarios::where([
                        ['coordinacion_id' , $coordinacion->id],
                        ['final', null]
                    ])->get();
                    
                    if(!$produccion->isEmpty()) 
                    {  
                        foreach ($produccion as $fuerzatarea) {
                            /**
                             * Actualiza el estatus de la fuerza de tarea
                             */
                            $operario = FuerzaTarea::find($fuerzatarea->fuerza_tarea_id);
                            $operario->status = '0';
                            $operario->coordinacion_id = '0';
                            $operario->save();
                            
                            if(empty($fuerzaTarea->final)){
                                /**
                                 * Actualiza la hora final 
                                 */
                                $fuerzatarea->final = $now;
                                $fuerzatarea->save();
                            }
                        }
                    }
                }
            break;
        }

        $tarea->save();
        $coordinacion->save();
        event(new ManiobraUpdate($coordinacion));

        return $coordinacion->toJson();

    }

    public function procesoFinManiobra(Request $request){
        $now = Carbon::now();
        $coordinacion = Coordinacion::where( 'servicio_id' , $request->servicio )->first();
        $tareas = $coordinacion->tareas;
        $lastTarea = $tareas->last();
        //Finalizar ultima tarea   
        $lastTarea->final = $now; 
        $lastTarea->status ='finalizado';
        $lastTarea->save();
      
        if (!$coordinacion->termino_maniobra) {
            //Finalizacion coordinacion
            $coordinacion->termino_maniobra = $now; 
            $coordinacion->status='Finalizado';
            $coordinacion->avance_total =  '100'; 
            $coordinacion->indice_activo = '6';
            $coordinacion->save();
            
            //Liberar Supervisor
            $supervisor = Supervisor_activo::where([
                ['supervisor_id' , $coordinacion->supervisor_id],
                ['coordinacion_id' , $coordinacion->id]
            ])->first();
            
            if($supervisor){
                $supervisor->delete();
            }
            
            //Revision de tareas (por sino no se Iniciaron-Finalizaron las tareas)
                       
            foreach($tareas as $tarea){
                
                if(empty($tarea->inicio)){ 
                    $tarea->inicio = $tarea->created_at;
                    $tarea->save();
                }
                if(empty($tarea->final)){
                    $tarea->final = $tarea->updated_at;
                    $tarea->save();
                }
                if($tarea->status === 'en proceso'){
                    $tarea->status ='finalizado';
                    $tarea->save();
                }
                
            }
        }
                
        event(new ManiobraFin($coordinacion));
        event(new ManiobraUpdate($coordinacion));
        
        return $coordinacion->toJson();
    }
}
