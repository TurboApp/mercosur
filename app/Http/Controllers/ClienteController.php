<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Servicio;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use DataTables;

use Illuminate\Http\Request;

class ClienteController extends Controller
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
        $clientes = Cliente::latest()->paginate(15);

        return view('pages.clientes.index', compact('clientes'));

    }


    public function create()
    {
        return view('pages.clientes.create');
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

        $cliente = Cliente::create(request(['nombre','nombre_corto','email','telefono','celular','direccion','rfc','ciudad','codigo_postal']));

        $request->session()->flash('success', 'El cliente se agrego a la base de datos satisfactoriamente');
        return redirect('/clientes/'.$cliente->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $cliente)
    {
      $cliente=Cliente::find($cliente);
        if ($cliente===null) {
          $request->session()->flash('danger', 'No se encontro ningun dato');
          return redirect('/clientes/');
        } else {
          return view('pages.clientes.show', compact('cliente'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $cliente)
    {
        $cliente=Cliente::find($cliente);
        if ($cliente===null) {
          $request->session()->flash('danger', 'No se encontro ningun dato');
          return redirect('/clientes/');
        } else {
          return view('pages.clientes.edit', compact('cliente'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
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

        $update = Cliente::findOrFail($cliente->id);
        //Prepara los nuevos valores de los datos
        $input = $request->all();
        //proceso de guardatos en la tabla/modelo datos_empresas
        $update->fill($input)->save();
        // //Se envia mensaje y se redirecciona a la vista clientes.show
        $request->session()->flash('success', 'Los datos se guardaron correctamente');
        return redirect('/clientes/' . $cliente->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cliente $cliente)
    {

        $del = Cliente::find($cliente->id);
        if(count($del))
        {
            $del->delete();
        }
        var_dump($user->id);
        //$request->session()->flash('success', 'El registro fue elimano correctamente');

        return redirect('/clientes');
    }


    public function search(Request $request)
    {

        $clientes = Cliente::where('nombre', 'LIKE','%'.$request->s.'%')->orWhere('nombre_corto', 'LIKE','%'.$request->s.'%')->paginate(15);
        $clientes->appends(['s'=>$request->s]);
        return view('pages.clientes.search', compact('clientes','request'));
    }


    public function metrica(Request $request, $cliente)
    {
        $cliente = Cliente::find($cliente);
        if ($cliente===null) {
          $request->session()->flash('danger', 'No se encontro ningun dato');
          return redirect('/clientes/');
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
        $servicios = Servicio::where( 'cliente_id' , $cliente->id )->get();
         //dd($servicios->isEmpty());
        if($servicios->isEmpty()){
            $cliente->semana = $week;
            $cliente->totalSemanaDescarga=0;
            $cliente->totalSemanaCarga=0;
            $cliente->totalSemanaTrasbordo=0;
            $cliente->totalMes = 0;
            $cliente->descargasTotalMes = 0;
            $cliente->cargasTotalMes = 0;
            $cliente->trasbordoTotalMes = 0;
            $cliente->metricaByYear = $metricaYear;
        
            //Total de todos los tiempo
            $cliente->totalServicios = 0;
            $cliente->descargasTotal = 0;
            $cliente->cargasTotal = 0;
            $cliente->trasbordosTotal = 0;

            return view('pages.clientes.metricas', compact('cliente'));
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
                        ->where('cliente_id',$cliente->id)->get();
            }else{
                $inicio = $diaSemana->subDays($diaSemana->dayOfWeek - 1);
                $fin = $servicios->last()->fecha_recepcion;
                $semana = Servicio::whereBetween("fecha_recepcion", [$inicio,$fin])
                        ->where('cliente_id',$cliente->id)->get();
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

        $cliente->semana = $week;
        $cliente->totalSemanaDescarga=$tsd;
        $cliente->totalSemanaCarga=$tsc;
        $cliente->totalSemanaTrasbordo=$tst;
        //METRICAS DEL MES
        $inicioMes = new Carbon('first day of this month');
        $finMes = new Carbon('last day of this month');
        $cliente->totalMes = servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->where('cliente_id',$cliente->id)->count();

        $cliente->descargasTotalMes = Servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->where([['cliente_id',$cliente->id],['tipo','Descarga']])->count();

        $cliente->cargasTotalMes = Servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->where([['cliente_id',$cliente->id],['tipo','Carga']])->count();

        $cliente->trasbordoTotalMes = Servicio::whereBetween("fecha_recepcion", [ $inicioMes->format('Y-m-d') , $finMes->format('Y-m-d') ])
                      ->where([['cliente_id',$cliente->id],['tipo','Trasbordo']])->count();

        

        //METRICAS POR AÑO
         
        $year = Servicio::whereYear( 'fecha_recepcion', date('Y') )->whereMonth('fecha_recepcion', date('m'))->get();
        
        for( $i = 0; $i < 12; $i++ ){
            $metricaYear['descargas'][$i] = Servicio::where([['cliente_id',$cliente->id],['tipo','Descarga']])->whereYear( 'fecha_recepcion', date('Y') )->whereMonth( 'fecha_recepcion', $i+1 )->count();
            $metricaYear['cargas'][$i] = Servicio::where([['cliente_id',$cliente->id],['tipo','Carga']])->whereYear( 'fecha_recepcion', date('Y') )->whereMonth( 'fecha_recepcion', $i+1 )->count();
            $metricaYear['trasbordos'][$i] = Servicio::where([['cliente_id',$cliente->id],['tipo','Trasbordo']])->whereYear( 'fecha_recepcion', date('Y') )->whereMonth( 'fecha_recepcion', $i+1 )->count();
        } 
        $cliente->metricaByYear = $metricaYear;
        
        //Total de todos los tiempo
        $cliente->totalServicios = servicio::where('cliente_id',$cliente->id)->count();

        $cliente->descargasTotal = Servicio::where([['cliente_id',$cliente->id],['tipo','Descarga']])->count();

        $cliente->cargasTotal = Servicio::where([['cliente_id',$cliente->id],['tipo','Carga']])->count();

        $cliente->trasbordosTotal = Servicio::where([['cliente_id',$cliente->id],['tipo','Trasbordo']])->count();
        
        return view('pages.clientes.metricas', compact('cliente'));
    }

    public function APImetrica(Request $request, $cliente)
    {
        $data = Servicio::where('cliente_id', $cliente)->get();
        
        $metricaYear = array(); 
        $firstData = Servicio::where('cliente_id', $cliente)->first();
        if(empty($firstData)){
            $year = date('Y');
        }else{
            $year = $firstData->fecha_recepcion->format('Y');
        }
        $descargas=0;
        $cargas=0;
        $trasbordos=0;
        for( $i = $year; $i <= date('Y'); $i++ ){
            $descargas = Servicio::where([['cliente_id',$cliente],['tipo','Descarga']])->whereYear( 'fecha_recepcion', $i )->count();
            $cargas = Servicio::where([['cliente_id',$cliente],['tipo','Carga']])->whereYear( 'fecha_recepcion', $i )->count();
            $trasbordos = Servicio::where([['cliente_id',$cliente],['tipo','Trasbordo']])->whereYear( 'fecha_recepcion', $i )->count();
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
