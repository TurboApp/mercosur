<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\FuerzaTarea;

class FuerzaTareaController extends Controller
{
    public function index(){
      $fuerzas=FuerzaTarea::all();
      return view('pages.fuerzas.index',compact('fuerzas'));
    }

    public function create()
    {
      return view('pages.fuerzas.create');
    }

    public function store(Request $request){
      $this->validate($request,[
        'nombre' => 'required',
        'apellido' => 'required',
        'telefono' => 'nullable|max:10',
        'celular' => 'nullable|max:10',
        'direccion' => 'nullable',
        'categoria' => 'required',

      ]);
      $fuerzas=(new FuerzaTarea)->fill($request->all());
      $fuerzas->save();
      $request->session()->flash('success', 'Un nuevo operario '.$fuerzas->nombre.' se agrego satisfactoriamente');
      return redirect('/fuerzas/');
    }

    public function show(FuerzaTarea $fuerza){
      return view('pages.fuerzas.show',compact('fuerza'));
    }

    public function edit(FuerzaTarea $fuerza){
      return view('pages.fuerzas.edit',compact('fuerza'));
    }

    public function update(Request $request, FuerzaTarea $fuerza){
        $this->validate($request,[
          'nombre' => 'required',
          'apellido' => 'required',
          'telefono' => 'nullable|max:10',
          'celular' => 'nullable|max:10',
          'direccion' => 'nullable',
          'categoria' => 'required',
        ]);
        $fuerza=FuerzaTarea::find($fuerza->id);
        $fuerza->update($request->only('nombre','apellido','direccion','telefono','celular','categoria'));
        $request->session()->flash('success', 'El operario '.$fuerza->nombre.' se ha actualizado satisfactoriamente');
        return redirect('/fuerzas/'.$fuerza->id);
    }

    public function destroy(Request $request, FuerzaTarea $fuerza){
      $eliminar=FuerzaTarea::find($fuerza->id);
      if(count($eliminar)){
        $eliminar->delete();
      }
      $request->session()->flash('success', 'El registro fue elimado');
    }
}
