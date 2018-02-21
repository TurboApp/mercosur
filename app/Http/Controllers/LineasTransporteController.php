<?php

namespace App\Http\Controllers;

use App\LineasTransporte;
use Illuminate\Http\Request;
use App\ServicioTransporte;
use App\Servicio;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use DataTables;

class LineasTransporteController extends Controller
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
        $transportes=LineasTransporte::latest()->paginate(15);
        return view('pages.transportes.index',compact('transportes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.transportes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd(request()->all());
        $this->validate(request(),[
          'nombre' => 'required',
          'nombre_corto' => 'required',
          'rfc' => 'required',
          'pais' => 'required',
          'email' => 'nullable|email'
        ]
      );

        $transporte=LineasTransporte::create(request(['nombre','nombre_corto','tipo','email','telefono','celular','direccion','rfc','codigo_postal','ciudad','pais']));
        $request->session()->flash('success', 'Una nueva Linea de Transporte fue agregado exitosamente');
        return redirect('/transportes/'.$transporte->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LineasTransporte  $lineasTransporte
     * @return \Illuminate\Http\Response
     */
    public function show(LineasTransporte $transporte)
    {
        return view('pages.transportes.show', compact('transporte'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LineasTransporte  $lineasTransporte
     * @return \Illuminate\Http\Response
     */
    public function edit(LineasTransporte $transporte)
    {
        return view('pages.transportes.edit',compact('transporte'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LineasTransporte  $lineasTransporte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LineasTransporte $transporte)
    {
      //Valida los datos
       $this->validate(request(),
           [
               'nombre' => 'required',
               'nombre_corto' => 'required',
               'rfc'    => 'required',
               'pais'   =>  'required',
               'email'  => 'nullable|email'
           ]
       );
       //Prepara los nuevos valores de los datos
       $inputs = [ 'nombre'=>$request->nombre,'nombre_corto'=>$request->nombre_corto,'email'=>$request->email , 'telefono'=>$request->telefono , 'celular' => $request->celular , 'direccion' => $request->direccion , 'rfc' => $request->rfc , 'ciudad' => $request->ciudad , 'codigo_postal' => $request->codigo_postal, 'pais' => $request->pais, 'tipo' => $request->tipo ];
       //proceso de guardatos en la tabla/modelo datos_empresas
       $transporte = LineasTransporte::find($transporte->id);
       $transporte->fill($inputs);
       $transporte->save();
       //Se envia mensaje y se redirecciona a la vista clientes.show
       $request->session()->flash('success', 'Los datos se guardaron correctamente');
       return redirect('/transportes/' . $transporte->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LineasTransporte  $lineasTransporte
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineasTransporte $transporte)
    {
        $destino = LineasTransporte::find($transporte->id);
      if(count($transporte))
      {
          $transporte->delete();
      }

      $request->session()->flash('success', 'El registro fue elimado correctamente');
    }

    public function search(Request $request)
   {

       $transportes = LineasTransporte::where('nombre','LIKE','%'.$request->s.'%')->paginate(15);
       $transportes->appends( [ 's' => $request->s ] );
       return view('pages.transportes.search', compact('transportes','request'));
   }

   public function metrica(Request $request, $transporte)
    {
        $transporte = LineasTransporte::find($transporte);
        
        if ($transporte===null) {
          $request->session()->flash('danger', 'No se encontro ningun dato');
          return redirect('/transportes/');
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
        $servicios = ServicioTransporte::where('linea_transporte_id',$transporte->id)->get();
        
        if($servicios->isEmpty()){
            $transporte->semana = $week;
            $transporte->totalSemanaDescarga=0;
            $transporte->totalSemanaCarga=0;
            $transporte->totalSemanaTrasbordo=0;
            $transporte->totalMes = 0;
            $transporte->descargasTotalMes = 0;
            $transporte->cargasTotalMes = 0;
            $transporte->trasbordoTotalMes = 0;
            $transporte->metricaByYear = $metricaYear;
        
            //Total de todos los tiempo
            $transporte->totalServicios = 0;
            $transporte->descargasTotal = 0;
            $transporte->cargasTotal = 0;
            $transporte->trasbordosTotal = 0;

            return view('pages.transportes.metricas', compact('transporte'));
        }
        $servicio_recepcion = Servicio::where('id',$servicios->last()->servicio_id)->first();
        $diaSemana = Carbon::parse($servicio_recepcion->fecha_recepcion);
        $lunes = Carbon::now()->startOfWeek();
        $domingo = Carbon::now()->endOfWeek();
        $tsd = 0; //TotalSemanaDescarga
        $tsc = 0; //TotalSemanaCarga
        $tst = 0; //TotalSemanaTrasbordo
        if( $diaSemana->between( $lunes , $domingo ) )
        {
            if($diaSemana->dayOfWeek == 1){
                $inicio = $servicio_recepcion->fecha_recepcion;
                $semana = Servicio::whereDate("fecha_recepcion", $inicio)
                        ->whereHas('transportes', function($query) use ($transporte){
                            $query->where('linea_transporte_id', $transporte->id);
                        })->get();
            }else{
                $inicio = $diaSemana->subDays($diaSemana->dayOfWeek - 1);
                $fin = $servicio_recepcion->fecha_recepcion;
                // $semana = Servicio::whereBetween("fecha_recepcion", [$inicio,$fin])
                //           ->where('agente_id',$agente->id)->get();
                $semana = Servicio::whereBetween("fecha_recepcion", [$inicio,$fin])->whereHas('transportes', function($query) use ($transporte){
                    $query->where('linea_transporte_id', $transporte->id);
                })->get();
            }

            foreach( $semana as $dia ){
                $day = Carbon::parse($dia->fecha_recepcion);
                for($i = $day->dayOfWeek; $i > 0; $i-- ){
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
        
        $transporte->semana = $week;
        $transporte->totalSemanaDescarga=$tsd;
        $transporte->totalSemanaCarga=$tsc;
        $transporte->totalSemanaTrasbordo=$tst;

        //METRICAS DEL MES
        $inicioMes = new Carbon('first day of this month');
        $finMes = new Carbon('last day of this month');
        $transporte->totalMes = servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->whereHas('transportes', function($query) use ($transporte){
                        $query->where('linea_transporte_id', $transporte->id);
                    })->count();

        $transporte->descargasTotalMes = Servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->whereHas('transportes', function($query) use ($transporte){
                        $query->where('linea_transporte_id', $transporte->id);
                    })->where('tipo','Descarga')->count();

        $transporte->cargasTotalMes = Servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->whereHas('transportes', function($query) use ($transporte){
                        $query->where('linea_transporte_id', $transporte->id);
                    })->where('tipo','Carga')->count();

        $transporte->trasbordoTotalMes = Servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->whereHas('transportes', function($query) use ($transporte){
                        $query->where('linea_transporte_id', $transporte->id);
                    })->where('tipo','Trasbordo')->count();

        

        //METRICAS POR AÑO
         $metricaYear = array(
             'descargas' => [],
             'cargas' => [],
             'trasbordos' => [],
         ); 
        $year = Servicio::whereYear( 'fecha_recepcion', date('Y') )->whereMonth('fecha_recepcion', date('m'))
                ->whereHas('transportes', function($query) use ($transporte){
                    $query->where('linea_transporte_id', $transporte->id);
                })->get();
        
        for( $i = 0; $i < 12; $i++ ){
            $metricaYear['descargas'][$i] = Servicio::where('tipo','Descarga')->whereYear( 'fecha_recepcion', date('Y') )
                                            ->whereMonth( 'fecha_recepcion', $i+1 )
                                            ->whereHas('transportes', function($query) use ($transporte){
                                                $query->where('linea_transporte_id', $transporte->id);
                                            })->count();
            $metricaYear['cargas'][$i] = Servicio::where('tipo','Carga')->whereYear( 'fecha_recepcion', date('Y') )
                                         ->whereMonth( 'fecha_recepcion', $i+1 )
                                         ->whereHas('transportes', function($query) use ($transporte){
                                            $query->where('linea_transporte_id', $transporte->id);
                                        })->count();
            $metricaYear['trasbordos'][$i] = Servicio::where('tipo','Trasbordo')->whereYear( 'fecha_recepcion', date('Y') )
                                            ->whereMonth( 'fecha_recepcion', $i+1 )
                                            ->whereHas('transportes', function($query) use ($transporte){
                                                $query->where('linea_transporte_id', $transporte->id);
                                            })->count();
        } 
        $transporte->metricaByYear = $metricaYear;
        
        //Total de todos los tiempo
        $transporte->totalServicios = servicio::whereHas('transportes', function($query) use ($transporte){
                                        $query->where('linea_transporte_id', $transporte->id);
                                    })->count();

        $transporte->descargasTotal = Servicio::whereHas('transportes', function($query) use ($transporte){
                                    $query->where('linea_transporte_id', $transporte->id);
                                })->where('tipo','Descarga')->count();

        $transporte->cargasTotal = Servicio::whereHas('transportes', function($query) use ($transporte){
                                    $query->where('linea_transporte_id', $transporte->id);
                                })->where('tipo','Carga')->count();

        $transporte->trasbordosTotal = Servicio::whereHas('transportes', function($query) use ($transporte){
                                        $query->where('linea_transporte_id', $transporte->id);
                                    })->where('tipo','Trasbordo')->count();
        
        return view('pages.transportes.metricas', compact('transporte'));
    }

    public function APImetrica(Request $request, $transporte)
    {
        $data = Servicio::whereHas('transportes', function($query) use ($transporte){
                            $query->where('linea_transporte_id', $transporte);
                        })->get();
        
        $metricaYear = array(); 
        $firstData = Servicio::whereHas('transportes', function($query) use ($transporte){
                        $query->where('linea_transporte_id', $transporte);
                    })->first();
        
        if(empty($firstData)){
            $year = date('Y');
        }else{
            $year = $firstData->fecha_recepcion->format('Y');
        }
        $descargas=0;
        $cargas=0;
        $trasbordos=0;
        for( $i = $year; $i <= date('Y'); $i++ ){
            $descargas = Servicio::whereHas('transportes', function($query) use ($transporte){
                            $query->where('linea_transporte_id', $transporte);
                        })->where('tipo','Descarga')->whereYear( 'fecha_recepcion', $i )->count();
            $cargas = Servicio::whereHas('transportes', function($query) use ($transporte){
                                $query->where('linea_transporte_id', $transporte);
                            })->where('tipo','Carga')->whereYear( 'fecha_recepcion', $i )->count();
            $trasbordos = Servicio::whereHas('transportes', function($query) use ($transporte){
                                $query->where('linea_transporte_id', $transporte);
                            })->where('tipo','Trasbordo')->whereYear( 'fecha_recepcion', $i )->count();
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


}
