<?php

namespace App\Http\Controllers;

use App\Destino;
use Illuminate\Http\Request;

class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $destinos=Destino::latest()->paginate(15);
        return view('pages.destinos.index',compact('destinos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.destinos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
          'nombre' => 'required',
          'email' => 'nullable|email'

        ]
      );
      $destino = Destino::create(request(['nombre','email','telefono','celular','direccion','rfc','ciudad','codigo_postal','pais']));
      $request->session()->flash('success', 'Un nuevo destino fue agregado exitosamente');
      return redirect('/destinos/'.$destino->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Destino  $destino
     * @return \Illuminate\Http\Response
     */
    public function show(Destino $destino)
    {
      return view('pages.destinos.show', compact('destino'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Destino  $destino
     * @return \Illuminate\Http\Response
     */
    public function edit(Destino $destino)
    {
        return view('pages.destinos.edit', compact('destino'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Destino  $destino
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destino $destino)
    {
      //Valida los datos
     $this->validate(request(),
         [
             'nombre' => 'required',
             'email'  => 'nullable|email'
         ]
     );
     //Prepara los nuevos valores de los datos
     $inputs = [ 'nombre'=>$request->nombre,'email'=>$request->email , 'telefono'=>$request->telefono , 'celular' => $request->celular , 'direccion' => $request->direccion , 'rfc' => $request->rfc , 'ciudad' => $request->ciudad , 'codigo_postal' => $request->codigo_postal, 'pais' => $request->pais ];
     //proceso de guardatos en la tabla/modelo datos_empresas
     $destino = Destino::find($destino->id);
     $destino->fill($inputs);
     $destino->save();
     //Se envia mensaje y se redirecciona a la vista clientes.show
     $request->session()->flash('success', 'Los datos se guardaron correctamente');
     return redirect('/destinos/' . $destino->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Destino  $destino
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destino $destino)
    {

      $destino = Destino::find($destino->id);
      if(count($destino))
      {
          $destino->delete();
      }

      $request->session()->flash('success', 'El registro fue elimado correctamente');
    }

    public function search(Request $request){
      $destinos = Destino::where('nombre','LIKE','%'.$request->s.'%')->paginate(15);
        return view('pages.destinos.search', compact('destinos','request'));
    }
}
