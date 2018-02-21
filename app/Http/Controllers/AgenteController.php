<?php

namespace App\Http\Controllers;

use App\Agente;
use App\Servicio;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use DataTables;

use Illuminate\Http\Request;

class AgenteController extends Controller
{
    function __construct(){
        $this->middleware(['auth','perfils:admin,go,directivo']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $agentes = Agente::latest()->paginate(15);
        return view('pages.agentes.index', compact('agentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.agentes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(request(),
            [
                'nombre' => 'required',
                'nombre_corto' => 'required',
                'rfc'    => 'required',
                'email'  => 'nullable|email'
            ]
        );

        $agente = Agente::create(request(['nombre','nombre_corto','email','telefono','celular','direccion','rfc','ciudad','codigo_postal']));

        $request->session()->flash('success', 'Un nuevo Agente se agrego satisfactoriamente');
        return redirect('/agentes/'.$agente->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agente  $agente
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $agente)
    {
        $agente=Agente::find($agente);
        if ($agente===null) {
          $request->session()->flash('danger', 'No se encontro ningun dato');
          return redirect('/agentes/');
        } else {
          return view('pages.agentes.show', compact('agente'));
        }

    }

    public function metrica(Request $request, $agente)
    {
        $agente = Agente::find($agente);
        if ($agente===null) {
          $request->session()->flash('danger', 'No se encontro ningun dato');
          return redirect('/agentes/');
        }
        
        //METRICAS DE LA SEMANA
        $week = array(
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
            [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        ); 
        $metricaYear = array(
            'descargas' => [],
            'cargas' => [],
            'trasbordos' => [],
        ); 
        $servicios = Servicio::where('agente_id',$agente->id)->get();

        if($servicios->isEmpty()){
            $agente->semana = $week;
            $agente->totalSemanaDescarga=0;
            $agente->totalSemanaCarga=0;
            $agente->totalSemanaTrasbordo=0;
            $agente->totalMes = 0;
            $agente->descargasTotalMes = 0;
            $agente->cargasTotalMes = 0;
            $agente->trasbordoTotalMes = 0;
            $agente->metricaByYear = $metricaYear;
        
            //Total de todos los tiempo
            $agente->totalServicios = 0;
            $agente->descargasTotal = 0;
            $agente->cargasTotal = 0;
            $agente->trasbordosTotal = 0;

            return view('pages.agentes.metricas', compact('agente'));
        }

        $diaSemana = Carbon::parse($servicios->last()->fecha_recepcion);
        $lunes = Carbon::now()->startOfWeek();
        $domingo = Carbon::now()->endOfWeek();
        $tsd = 0; //TotalSemanaDescarga
        $tsc = 0; //TotalSemanaCarga
        $tst = 0; //TotalSemanaTrasbordo
        
        if( $diaSemana->between( $lunes , $domingo ) )
        {
            if($diaSemana->dayOfWeek == 1){
                $inicio = $servicios->last()->fecha_recepcion;
                $semana = Servicio::whereDate("fecha_recepcion", $inicio)
                        ->where('agente_id',$agente->id)->get();
            }else{
                $inicio = $diaSemana->subDays($diaSemana->dayOfWeek - 1);
                $fin = $servicios->last()->fecha_recepcion;
                $semana = Servicio::whereBetween("fecha_recepcion", [$inicio,$fin])
                        ->where('agente_id',$agente->id)->get();
            }
            
            
            foreach( $semana as $dia )
            {
                $day = Carbon::parse($dia->fecha_recepcion);
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
                            $tsc += 1; 
                        }
                    }
                }
            }
        }

        $agente->semana = $week;
        $agente->totalSemanaDescarga=$tsd;
        $agente->totalSemanaCarga=$tsc;
        $agente->totalSemanaTrasbordo=$tst;
        
        //METRICAS DEL MES
        $inicioMes = new Carbon('first day of this month');
        $finMes = new Carbon('last day of this month');
        $agente->totalMes = servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->where('agente_id',$agente->id)->count();

        $agente->descargasTotalMes = Servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->where([['agente_id',$agente->id],['tipo','Descarga']])->count();

        $agente->cargasTotalMes = Servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->where([['agente_id',$agente->id],['tipo','Carga']])->count();

        $agente->trasbordoTotalMes = Servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->where([['agente_id',$agente->id],['tipo','Trasbordo']])->count();

        

        //METRICAS POR AÑO
        
        $year = Servicio::whereYear( 'fecha_recepcion', date('Y') )->whereMonth('fecha_recepcion', date('m'))->get();
        
        for( $i = 0; $i < 12; $i++ ){
            $metricaYear['descargas'][$i] = Servicio::where([['agente_id',$agente->id],['tipo','Descarga']])->whereYear( 'fecha_recepcion', date('Y') )->whereMonth( 'fecha_recepcion', $i+1 )->count();
            $metricaYear['cargas'][$i] = Servicio::where([['agente_id',$agente->id],['tipo','Carga']])->whereYear( 'fecha_recepcion', date('Y') )->whereMonth( 'fecha_recepcion', $i+1 )->count();
            $metricaYear['trasbordos'][$i] = Servicio::where([['agente_id',$agente->id],['tipo','Trasbordo']])->whereYear( 'fecha_recepcion', date('Y') )->whereMonth( 'fecha_recepcion', $i+1 )->count();
        } 
        $agente->metricaByYear = $metricaYear;
        
        //Total de todos los tiempo
        $agente->totalServicios = servicio::where('agente_id',$agente->id)->count();

        $agente->descargasTotal = Servicio::where([['agente_id',$agente->id],['tipo','Descarga']])->count();

        $agente->cargasTotal = Servicio::where([['agente_id',$agente->id],['tipo','Carga']])->count();

        $agente->trasbordosTotal = Servicio::where([['agente_id',$agente->id],['tipo','Trasbordo']])->count();
        
        return view('pages.agentes.metricas', compact('agente'));
    }

    public function APImetrica(Request $request, $agente)
    {
        $data = Servicio::where('agente_id', $agente)->get();
        
        $metricaYear = array(); 
        $firstData = Servicio::where('agente_id', $agente)->first();
        if(empty($firstData)){
            $year = date('Y');
        }else{
            $year = $firstData->fecha_recepcion->format('Y');
        }
        $descargas=0;
        $cargas=0;
        $trasbordos=0;
        for( $i = $year; $i <= date('Y'); $i++ ){
            $descargas = Servicio::where([['agente_id',$agente],['tipo','Descarga']])->whereYear( 'fecha_recepcion', $i )->count();
            $cargas = Servicio::where([['agente_id',$agente],['tipo','Carga']])->whereYear( 'fecha_recepcion', $i )->count();
            $trasbordos = Servicio::where([['agente_id',$agente],['tipo','Trasbordo']])->whereYear( 'fecha_recepcion', $i )->count();
            array_push($metricaYear,[
                'year' => $i,
                'descargas' => $descargas,
                'cargas' => $cargas,
                'trasbordos' => $trasbordos,
                'total' => $descargas + $cargas + $trasbordos
            ]); 
        }
        return DataTables::of($metricaYear)->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agente  $agente
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $agente)
    {
      $agente=Agente::find($agente);
      if ($agente===null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/agentes/');
      }
      else {
        return view('pages.agentes.edit', compact('agente'));
      }
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agente  $agente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agente $agente)
    {
         //Valida los datos
        $this->validate(request(),
            [
                'nombre' => 'required',
                'nombre_corto' => 'required',
                'rfc'    => 'required',
                'email'  => 'nullable|email'
            ]
        );
        //Prepara los nuevos valores de los datos
        $inputs = [ 'nombre'=>$request->nombre,'nombre_corto'=>$request->nombre_corto,'email'=>$request->email , 'telefono'=>$request->telefono , 'celular' => $request->celular , 'direccion' => $request->direccion , 'rfc' => $request->rfc , 'ciudad' => $request->ciudad , 'codigo_postal' => $request->codigo_postal ];
        //proceso de guardatos en la tabla/modelo datos_empresas
        $agente = Agente::find($agente->id);
        $agente->fill($inputs);
        $agente->save();
        //Se envia mensaje y se redirecciona a la vista clientes.show
        $request->session()->flash('success', 'Los datos se guardaron correctamente');
        return redirect('/agentes/' . $agente->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agente  $agente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Agente $agente)
    {
        $agente = Agente::find($agente->id);
        if(count($agente))
        {
            $agente->delete();
        }

        $request->session()->flash('success', 'El registro fue elimado correctamente');
    }

     public function search(Request $request)
    {

        $agentes = Agente::where('nombre', 'LIKE','%'.$request->s.'%')->orWhere('nombre_corto', 'LIKE','%'.$request->s.'%')->paginate(15);
        $agentes->appends( [ 's' => $request->s ] );

        return view('pages.agentes.search', compact('agentes','request'));
    }


    ///API devuelve solo os datos sin vistas

    public function APIindex()
    {
        $agentes = Agente::get();
        return $agentes->toJson();;
    }

    
}
