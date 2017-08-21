<?php

namespace App\Http\Controllers;

use App\OrdenServicio;
use App\Agente;
use App\TipoUnidad;
use App\UnidadesDeMedida;
use App\Eje;
use Carbon\Carbon;
use Jenssegers\Date\Date;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data["tipo_servicio"]= ['Carga'=>'Carga','Descarga'=>'Descarga','Trasbordos'=>'Trasbordos','Otros servicios'=>'Otros servicios'];
        $data["agentes"] = Agente::get();
        $data["tipo"] = TipoUnidad::get()->pluck('unidad');
        $today=Carbon::now();
        $today = Date::instance(Carbon::now());
        dd($data);
        //$date = Carbon::createFromFormat('d/m/Y', "$today->day/$today->month/$today->year");
        $data["hoy"]=$today;
        //array_push($data["tipo_servicio"],$tipo_servicios);
        //dd($data);
        return view('pages.traficos.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrdenServicio  $ordenServicio
     * @return \Illuminate\Http\Response
     */
    public function show(OrdenServicio $ordenServicio)
    {
        //
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
}
