<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Coordinacion;
use App\OrdenServicio;
use App\Agente;
use App\User;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use DataTables;

class APIController extends Controller
{
    public function coordinacion(Request $request)
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

    public function almacen(Request $request)
    {
        $fecha=Carbon::today()->format('Y-m-d');
        $fechas=explode("*",$request->date);

        if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
            $servicios = OrdenServicio::whereBetween("fecha_recepcion", [$fechaInicio, $fechaFinal])
                ->whereHas('documentosDescarga', function($q){
                        $q->where('status','>','0');
                })->get();
        }
        else if( $request->date )
        {
            $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
            $servicios = OrdenServicio::where("fecha_recepcion", $fecha)->whereHas('documentosDescarga', function($q){
                $q->where('status','>','0');
            })->get();
        }else{
            $servicios = OrdenServicio::where("fecha_recepcion", $fecha)->whereHas('documentosDescarga', function($q){
                $q->where('status','>','0');
            })->get();
        }
        
        foreach($servicios as $servicio){
            $servicio->cliente;
            $servicio->documentosDescarga->each(function($item, $key) {
                $item['nombre'] = $item->tipo_documento."-".$item->documento;
            });
            $servicio['fecha'] = strtoupper(Date::instance(Carbon::createFromFormat("Y-m-d","$servicio->fecha_recepcion"))->format('d/M/Y'));
        }

        return DataTables::of($servicios)->toJson();
    }

    public function almacenItem(Request $request )
    {
        $servicio=OrdenServicio::find($request->servicio);
        $servicio->cliente;
        $servicio->agente;
        $servicio->documentosDescarga;
        return $servicio->toJson();
    }
    
    public function servicios(Request $request)
    {
        $fecha=Carbon::today()->format('Y-m-d');
        $fechas=explode("*",$request->date);
        if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
            $servicios = OrdenServicio::whereBetween("fecha_recepcion", [$fechaInicio,$fechaFinal])->get();
        }
        else if( $request->date )
        {
            $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
            $servicios=OrdenServicio::where("fecha_recepcion", $fecha)->get();
        }else{
            $servicios=OrdenServicio::where("fecha_recepcion", $fecha)->get();
        }
        foreach($servicios as $servicio){
            $servicio->cliente;
            $servicio->agente;
            $servicio->documentosDescarga;
            $servicio->documentosCarga;
            $date_humans=Date::instance(Carbon::createFromFormat('Y-m-d',$servicio->fecha_recepcion))->format('l j \\d\\e F \\d\\e Y');
            $servicio['date_humans'] = $date_humans;
        }
        return DataTables::of($servicios)->toJson();
    }

    public function agentes()
    {
        $agentes = Agente::get();
        return $agentes->toJson();;
    }

    public function supervisores(Request $request)
    {
        if($request->s )
        {
            $supervisores = User::where([
                    ['perfil_id', '6'],
                    ['nombre', 'LIKE','%'.$request->s.'%']
                ])
                ->orWhere([
                    ['perfil_id', '6'],
                    ['apellido', 'LIKE','%'.$request->s.'%']
                ])->get();
        }
        else {
            $supervisores = User::whereHas('perfil', function($q){
                    $q->where('perfil','supervisor');
            })->get();
        }
        
        
        return $supervisores->toJson();
    }

    public function infoUser(User $user)
    {
        return $user->toJson();
    }

}
