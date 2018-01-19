<?php

namespace App\Http\Controllers;

use App\ListasEmpaque;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ListasEmpaqueController extends Controller
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
        //
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
        //$name=$request->name;
        $path = $request->file('file');
        
        //dd($path);

        //$name =$request->name;
        Excel::load($path, function($reader)
        {
         $results = $reader->get();
         ListasEmpaque::insert($results->toArray());
        });
        return '0';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ListasEmpaque  $listasEmpaque
     * @return \Illuminate\Http\Response
     */
    public function show(ListasEmpaque $listasEmpaque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ListasEmpaque  $listasEmpaque
     * @return \Illuminate\Http\Response
     */
    public function edit(ListasEmpaque $listasEmpaque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ListasEmpaque  $listasEmpaque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListasEmpaque $listasEmpaque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ListasEmpaque  $listasEmpaque
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListasEmpaque $listasEmpaque)
    {
        //
    }
}
