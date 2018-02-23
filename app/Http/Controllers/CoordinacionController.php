<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Coordinacion;
use App\ManiobraTarea  as Tareas;
use App\supervisor_activo;
use App\LineasTransporte as Transporte;

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
            return redirect('/coordinacion');
        }else{
            if(auth()->user()->perfil->perfil == 'coordinador'){
                return view('pages.coordinacion.master', compact('coordinacion'));
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
            return redirect('/');
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
    
}
