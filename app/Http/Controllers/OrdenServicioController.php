<?php

namespace App\Http\Controllers;

use App\OrdenServicio;
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
        return view('pages.traficos.create');
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

    public function autocomplete(){
      $dato=OrdenServicio::select('nombre'->where('nombre','LIKE','%'.$request->input('query').'%'))->get();
      return response()->json($dato);
    }

}
