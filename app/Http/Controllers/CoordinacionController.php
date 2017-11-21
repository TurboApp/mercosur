<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Coordinacion;
use App\supervisor_activo;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use DataTables;


class CoordinacionController extends Controller
{
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
        
        $servicio = Coordinacion::find($servicio);
        if($servicio===null){
            $request->session()->flash('danger', 'No se encontro ningun dato');
            return redirect('/coordinacion');
        }else{
            return view('pages.coordinacion.master', compact('servicio'));
        }
    }

    public function indexManiobra()
    {
        $data = Date::instance(Carbon::now());
        return view('pages.maniobras.index', compact('data'));
    }


    public function maniobraTareas(Coordinacion $coordinacion)
    {
        return view('pages.maniobras.tareas', compact('coordinacion'));
    }


    
    
}
