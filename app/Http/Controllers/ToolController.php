<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Puesto;

class ToolController extends Controller
{
    public function create(){
      $puestos=Puesto::all();
      return view('pages.herramientas.create',compact('puestos'));
    }

    public function store(Request $request){
        $this->validate(request(),[
          'puesto' => 'required'
        ]);
        $pu=(new Puesto)->fill($request->all());
        $pu->save();
        $request->session()->flash('success', 'El puesto '.$pu->puesto.' se agrego a la base de datos satisfactoriamente');
        return redirect('/herramientas/nuevo');
    }

    public function infopuesto(Puesto $puesto){
      return $puesto->toJson();
    }

    public function update(Request $request){
      $puesto=Puesto::find($request->id);
      $puesto->update($request->only('puesto','descripcion'));
      $request->session()->flash('success', 'El puesto '.$puesto->puesto.' se actualizo satisfactoriamente');
      return redirect('/herramientas/nuevo');
    }
}
