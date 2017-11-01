<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\FuerzaTarea;

class FuerzaTareaController extends Controller
{
    function __construct(){
      $this->middleware(['auth','perfils:admin']);
    }

    public function index(){
      $fuerzas=FuerzaTarea::latest()->paginate(16);
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

    public function show(Request $request, $fuerza){
      $fuerza=FuerzaTarea::find($fuerza);
      if ($fuerza===null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/fuerzas/');
      } else {
        return view('pages.fuerzas.show',compact('fuerza'));
      }

    }

    public function edit(Request $request, $fuerza){
      $fuerza=FuerzaTarea::find($fuerza);
      if ($fuerza===null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/fuerzas/');
      }
      else {
        return view('pages.fuerzas.edit',compact('fuerza'));
      }
    }

    public function update(Request $request, FuerzaTarea $fuerza){
        $this->validate($request,[
          'nombre' => 'required',
          'apellido' => 'required',
          'telefono' => 'nullable|max:20',
          'celular' => 'nullable|max:20',
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

    public function search(Request $request)
   {
       $fuerzas = FuerzaTarea::where('nombre', 'LIKE','%'.$request->s.'%')->orWhere('apellido', 'LIKE','%'.$request->s.'%')->paginate(16);
       $fuerzas->appends( [ 's' => $request->s ] );

       return view('pages.fuerzas.search', compact('fuerzas','request'));
   }
}
