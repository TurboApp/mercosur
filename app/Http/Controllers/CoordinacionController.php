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

    #### DETALLES ####

    public function maniobraDetalles(Coordinacion $servicio)
    {
        return view('pages.maniobra.detalles', compact('servicio'));
    }
    public function maniobraGenerales(Coordinacion $servicio)
    {
        return view('pages.maniobra.generales', compact('servicio'));
    }
    public function maniobraTransportes(Coordinacion $servicio)
    {
        return view('pages.maniobra.transportes', compact('servicio'));
    }
    public function maniobraDocumentos(Coordinacion $servicio)
    {
        return view('pages.maniobra.documentos', compact('servicio'));
    }
    public function maniobraArchivos(Coordinacion $servicio)
    {
        return view('pages.maniobra.archivos', compact('servicio'));
    }
    public function agregarSupervisor(Request $request, Coordinacion $coordinacion)
    {
               
        //Falta agregar el id del coordinador 
        $coordinacion->supervisor_id = $request->supervisor;
        $coordinacion->coordinador_id = auth()->user()->id;
        $coordinacion->save();

        return redirect()->back();
    }
}
