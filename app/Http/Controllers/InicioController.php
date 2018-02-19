<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;
use App\Cliente;
use App\Agente;
use App\Coordinacion;
use App\User;
use App\LineasTransporte;
use App\ProduccionOperarios;
use App\FuerzaTarea;

use Carbon\Carbon;
use DataTables;
use Jenssegers\Date\Date;

class InicioController extends Controller
{
    public function inicio()
    {

        $resumen = collect();
        $hoy = Carbon::now();
        $week = array(
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
          );
            //METRICAS 
            $resumen->descargasTotal = Servicio::where('tipo','Descarga')->count();
            $resumen->cargasTotal = Servicio::where('tipo','Carga')->count();
            $resumen->trasbordosTotal = Servicio::where('tipo','Trasbordo')->count();
            $resumen->serviciosTotal = $resumen->descargasTotal + $resumen->cargasTotal + $resumen->trasbordosTotal;
            

            //METRICAS POR DIA
            $resumen->descargasToday = Servicio::where('tipo','Descarga')->whereDate('created_at', $hoy->toDateString())->count();
            $resumen->cargasToday = Servicio::where('tipo','Carga')->whereDate('created_at', $hoy->toDateString())->count();
            $resumen->trasbordosToday = Servicio::where('tipo','Trasbordo')->whereDate('created_at', $hoy->toDateString())->count();
            $resumen->totalToday = $resumen->descargasToday + $resumen->cargasToday + $resumen->trasbordosToday;
            
            //METRICAS POR SEMANA
            $servicios = Servicio::all();
            
            if(!$servicios->isEmpty()){
                $diaSemana = Carbon::parse($servicios->last()->fecha_recepcion);
            }else{
                $diaSemana = 0;
            }
            $lunes = Carbon::now()->startOfWeek();
            $domingo = Carbon::now()->endOfWeek();
            $tsd = 0; //TotalSemanaDescarga
            $tsc = 0; //TotalSemanaCarga
            $tst = 0; //TotalSemanaTrasbordo
            
            if($diaSemana){

                if( $diaSemana->between( $lunes , $domingo ) )
                {
                    if($diaSemana->dayOfWeek == 1){
                        $inicio = $servicios->last()->fecha_recepcion;
                        $semana = Servicio::whereDate("fecha_recepcion", $inicio)->get();
                    }else{
                        $inicio = $diaSemana->subDays( $diaSemana->dayOfWeek - 1);
                        $fin = $servicios->last()->fecha_recepcion;
                        $semana = Servicio::whereBetween("fecha_recepcion", [$inicio, $fin])->get();
                    }
                    foreach( $semana as $dia ){
                        $day = Carbon::parse($dia->final);
                        for($i = $day->dayOfWeek; $i > 0; $i-- )
                        {
                            if($day->dayOfWeek == $i)
                            {
                                if($dia->tipo == 'Carga')
                                {
                                    $week[$i-1]['cargas'] = $week[$i-1]['cargas'] + 1;
                                    $tsc += 1; 
                                }
                                elseif($dia->tipo == 'Descarga')
                                {
                                    $week[$i-1]['descargas'] = $week[$i-1]['descargas'] + 1;
                                    $tsd += 1; 
                                }
                                elseif($dia->tipo == 'Trasbordo')
                                {
                                    $week[$i-1]['trasbordos'] = $week[$i-1]['trasbordos'] + 1;
                                    $tst += 1; 
                                }
                            }
                        }
                    }
                }
            }
            $resumen->semana = $week;
            $resumen->totalSemanaDescarga=$tsd;
            $resumen->totalSemanaCarga=$tsc;
            $resumen->totalSemanaTrasbordo=$tst;
           
            //TOPS CLIENTES, TRANSPORTES, AGENTES
            $clientes = Cliente::with('servicio')->get()->sortByDesc(function($cliente){
                return $cliente->servicio->count();
            })->take(3);

            $agentes = Agente::with('servicio')->get()->sortByDesc(function($agente){
                return $agente->servicio->count();
            })->take(3);

            $transportes = LineasTransporte::with('ordenservicios')->get()->sortByDesc(function($transporte){
                return $transporte->ordenservicios->count();
            })->take(3);
                       
            $resumen->topClientes = $clientes;
            $resumen->topAgentes = $agentes;
            $resumen->topTransportes = $transportes;

            //TOP FUERZA TAREA
            $montacarga = FuerzaTarea::with('produccion')->where('categoria','Montacarga')->get()->sortByDesc(function($operario){
                    return $operario->produccion->count();
                })->take(1);
            $auxiliar = FuerzaTarea::with('produccion')->where('categoria','Auxiliar de Patio')->get()->sortByDesc(function($operario){
                    return $operario->produccion->count();
                })->take(1);
            $montacarguista = FuerzaTarea::with('produccion')->where('categoria','Montacarguista')->get()->sortByDesc(function($operario){
                    return $operario->produccion->count();
                })->take(1);
            
                
            $resumen->topMontacarga = $montacarga;
            $resumen->topMontacarguista = $montacarguista;
            $resumen->topAuxiliar = $auxiliar;
            //TOP SUPERVISOR
            $supervisor = User::with('supervisor')->whereHas('perfil', function($q){
                            $q->where('perfil','supervisor');
                        })->get()->sortByDesc(function($supervisor){
                            return $supervisor->supervisor->count();
                        })->take(1);
            
            $resumen->topSupervisor = $supervisor;
            
            //TotalCliente
            $resumen->totalClientes = Cliente::all()->count();
            $resumen->totalAgentes = Agente::all()->count();
            $resumen->totalTransportes = LineasTransporte::all()->count();
            $resumen->totalUsuarios = User::all()->count();
            
            //DATOS SUPERVISOR
            $resumen->supervisorDescargasHoy = Coordinacion::where('supervisor_id',auth()->user()->id)
                            ->whereHas('servicio', function($q){
                                $q->where('tipo','Descarga');
                            })->whereDate('created_at', $hoy->toDateString())->count();
            $resumen->supervisorCargasHoy = Coordinacion::where('supervisor_id',auth()->user()->id)
                            ->whereHas('servicio', function($q){
                                $q->where('tipo','Descarga');
                            })->whereDate('created_at', $hoy->toDateString())->count();
            $resumen->supervisorTrasbordosHoy = Coordinacion::where('supervisor_id',auth()->user()->id)
                            ->whereHas('servicio', function($q){
                                $q->where('tipo','Descarga');
                            })->whereDate('created_at', $hoy->toDateString())->count();
            
            $resumen->supervisorServiciosHoy = $resumen->supervisorTrasbordosHoy + $resumen->supervisorCargasHoy + $resumen->supervisorDescargasHoy;

            

        return view('pages.inicio.'.auth()->user()->perfil->perfil, compact('resumen'));
    }

    public function error(){
      return view('pages.errors.503');
    }
}

