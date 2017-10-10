<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coordinacion;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use DataTables;

class CoordinacionController extends Controller
{
    public function index()
    {
        $data = Date::instance(Carbon::now());
        return view('pages.trafico.coordinacion', compact('data'));
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
                    //->groupBy('fecha_servicio')
                    ->with('servicio.cliente')
                    ->get();
        }
        else if( $request->date )
        {
            $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
            $data=Coordinacion::whereDate("fecha_servicio", $fecha)->with('servicio.cliente')->get();
        }else{
            $data=Coordinacion::whereDate("fecha_servicio", $fecha)->with('servicio.cliente')->get();
        }
        //dd($data);
        foreach($data as $item){
            //$servicio;
            //$item->servicio->cliente;
            $date_humans=Date::instance(Carbon::createFromFormat('Y-m-d',$item->servicio['fecha_recepcion']))->format('l j \\d\\e F \\d\\e Y');
            $item->servicio['date_humans'] = $date_humans;
        }
        //return $data;
        return DataTables::of($data)->toJson();

    }

}
