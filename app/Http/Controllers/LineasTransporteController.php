<?php

namespace App\Http\Controllers;

use App\LineasTransporte;
use Illuminate\Http\Request;

class LineasTransporteController extends Controller
{
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
          'rfc' => 'required',
          'pais' => 'required',
          'email' => 'nullable|email'
        ]
      );

        $transporte=LineasTransporte::create(request(['nombre','tipo','email','telefono','celular','direccion','rfc','codigo_postal','ciudad','pais']));
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
               'rfc'    => 'required',
               'pais'   =>  'required',
               'email'  => 'nullable|email'
           ]
       );
       //Prepara los nuevos valores de los datos
       $inputs = [ 'nombre'=>$request->nombre,'email'=>$request->email , 'telefono'=>$request->telefono , 'celular' => $request->celular , 'direccion' => $request->direccion , 'rfc' => $request->rfc , 'ciudad' => $request->ciudad , 'codigo_postal' => $request->codigo_postal, 'pais' => $request->pais, 'tipo' => $request->tipo ];
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
       return view('pages.transportes.search', compact('transportes','request'));
   }


}
