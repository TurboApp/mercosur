<?php

namespace App\Http\Controllers;

use App\Agente;

use Illuminate\Http\Request;

class AgenteController extends Controller
{
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
    public function show(Agente $agente)
    {
        return view('pages.agentes.show', compact('agente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agente  $agente
     * @return \Illuminate\Http\Response
     */
    public function edit(Agente $agente)
    {
       return view('pages.agentes.edit', compact('agente'));
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
