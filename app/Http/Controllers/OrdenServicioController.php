<?php

namespace App\Http\Controllers;

use App\OrdenServicio;
use App\Agente;
use App\Cliente;
use App\Archivo;
use App\OrdenServicioTransporte as Transporte;
use App\Documento;
use App\Coordinacion;

use App\Http\Requests\RequestServicio;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use DataTables;
use File;
use Response;

use Illuminate\Http\Request;

class OrdenServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Date::instance(Carbon::now());
        return view('pages.trafico.index', compact('data'));
    }
    public function indexAlmacen()
    {
        $data = Date::instance(Carbon::now());
        return view('pages.trafico.almacen', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function createIndex()
    {
       return view('pages.trafico.createIndex');
    }

    public function create(Request $request)
    {
        
        if($request->servicio !== "Descarga" && $request->servicio !== "Carga" && $request->servicio !== "Trasbordo")
        {
            return redirect('/trafico/nuevo');
        }
        $servicio='';
        if($request->id)
        {
            $servicio = OrdenServicio::find($request->id);
        }

        $data = [
            "numero_servicio" => OrdenServicio::getNumServicio(),
            "agentes" => Agente::get(),
            "hoy" => Date::instance(Carbon::now()),
            "tipo" => $request->servicio
        ];
        
        return view('pages.trafico.create', compact('data','servicio'));
    }

    public function createDescarga()
    {
        $data = [
            "numero_servicio" => OrdenServicio::getNumServicio(),
            "agentes" => Agente::get(),
            "hoy" => Date::instance(Carbon::now()),
            "tipo" => 'Descarga'
        ];
        
        return view('pages.trafico.createDescarga', compact('data'));
    }
    public function createCarga(OrdenServicio $servicio)
    {
        $data = array();
        $data["numero_servicio"]=OrdenServicio::orderBy('id','desc')->first()->id + 1;//devuelve la cantidad de servicios en la tabla y le suma uno
        $data["agentes"] = Agente::get();
        $data["hoy"]=Date::instance(Carbon::now());
        return view('pages.trafico.createCarga', compact('data', 'servicio'));
    }
    
    public function createTrasbordo(OrdenServicio $servicio)
    {
        $data = array();
        $data["numero_servicio"]=OrdenServicio::orderBy('id','desc')->first()->id + 1;//devuelve la cantidad de servicios en la tabla y le suma uno
        $data["agentes"] = Agente::get();
        $today=Carbon::now();
        $today = Date::instance(Carbon::now());
        $data["hoy"]=$today;
        return view('pages.trafico.createTrasbordo', compact('data', 'servicio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    
    public function store(RequestServicio $request)
    {
        //Store Datos generales - orden_servicios
        $ordenServicio=OrdenServicio::createOrdenServicio( ['tipo' => $request->tipo] + $request->datos_generales );
        
        //Store Transportes - orden_servicios_transportes
        foreach($request->transporte as $tipo => $transporte){
            $ordenServicio->addTransportes( ['type' => $tipo] + $transporte );
        }
        
        if($request->tipo === 'Carga'){
            //Update Documentos
            $ordenServicio->updateDocumentos($request->documento);
            
            //Update Archivos
            $ordenServicio->updateArchivos($request->archivo);
            
        }else{
            //Store Documentos - documentos
            $ordenServicio->addDocumentos($request->tipo, $request->documento);
        }
        //Store Archivos - archivos
        if($request->hasFile('files')){
            $ordenServicio->storearchivos($request->tipo, $request->file('files'));
        }
        
        //Asignar turno
        $date = str_replace('/', '-', $request->datos_generales['fecha_recepcion']);
        $date=date('Y-m-d', strtotime($date));
        $coordinacion = Coordinacion::whereDate( 'created_at', $date )->orderBy('turno','desc')->first();
        
        if($coordinacion){
            $turno = $coordinacion->turno + 1; 
        }else{
            $turno = 1;
        }
        
        //Store Coordinacion - coordinacions
        Coordinacion::create([
            'id_orden_servicio' => $ordenServicio->id,
            'turno'             => $turno,
            'fecha_servicio'    => $date
        ]);
            
        return redirect('/trafico/nuevo');
    }
       
    /**
     * Display the specified resource.
     *
     * @param  \App\OrdenServicio  $ordenServicio
     * @return \Illuminate\Http\Response
     */
    
    public function show(OrdenServicio $servicio)
    {
        
        return view('pages.trafico.show', compact('servicio'));
                      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrdenServicio  $ordenServicio
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdenServicio $ordenServicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrdenServicio  $ordenServicio
     * @return \Illuminate\Http\Response
     */ 
    public function update(Request $request, OrdenServicio $ordenServicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrdenServicio  $ordenServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdenServicio $ordenServicio)
    {
        //
    }

    public function getArchivo(Request $request)
    {
        $path = storage_path('app/documentos/'.$request->id .'/'. $request->archivo );
        if(!File::exists($path)) 
            $path = storage_path('app/public/avatars/') . 'default.png';
        
        $file = File::get($path);
        
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
        //return view('pages.viewer.index', compact('response'));
    }
    //API
    public function almacen(Request $request){
        $fecha=Carbon::today()->format('Y-m-d');
        $fechas=explode("*",$request->date);

        if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
            //$servicios = OrdenServicio::whereBetween("fecha_recepcion", [$fechaInicio,$fechaFinal])->get();
            $servicios = OrdenServicio::whereBetween("fecha_recepcion", [$fechaInicio, $fechaFinal])
                ->whereHas('documentosDescarga', function($q){
                        $q->where('status','>','0');
                })->get();
        }
        else if( $request->date )
        {
            $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
            //$servicios=OrdenServicio::where("fecha_recepcion", $fecha)->get();
            $servicios = OrdenServicio::where("fecha_recepcion", $fecha)->whereHas('documentosDescarga', function($q){
                $q->where('status','>','0');
            })->get();
        }else{
            //$servicios=OrdenServicio::where("fecha_recepcion", $fecha)->get();
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

    public function almacenItem(Request $request ){
        $servicio=OrdenServicio::find($request->servicio);
        $servicio->cliente;
        $servicio->agente;
        $servicio->documentosDescarga;
        return $servicio->toJson();
    }
    
    public function indexServicios(Request $request){
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
    
}
