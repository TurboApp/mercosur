<?php

namespace App\Http\Controllers;

use App\Cliente;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
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
    public function show(Cliente $cliente)
    {
        return view('pages.clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        return view('pages.clientes.edit', compact('cliente'));
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

    

}
