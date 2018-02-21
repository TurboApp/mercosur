<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\User;
use App\Puesto;
use App\Equipo;
use DataTables;

class PuestoController extends Controller
{
    function __construct()
    {
      $this->middleware(['auth','perfils:admin']);
    }
    ##PUESTOS  
    public function createPuesto()
    {
      $puestos=Puesto::all();
      return view('pages.herramientas.puestos',compact('puestos'));
    }

    public function get()
    {
      $puestos=Puesto::all();
      return DataTables::of($puestos)->toJson();
    }

    public function storePuesto(Request $request)
    {
        $this->validate(request(),[
          'puesto' => 'required'
        ]);
        $pu=(new Puesto)->fill($request->all());
        $pu->save();
        //$request->session()->flash('success', 'El puesto '.$pu->puesto.' se agrego a la base de datos satisfactoriamente');
        return $pu->toJson();//redirect('/herramientas/puestos');
    }

    public function infopuesto(Puesto $puesto)
    {
      return $puesto->toJson();
    }

    public function update(Request $request)
    {
      $this->validate(request(),[
        'puesto' => 'required'
      ]);
      $puesto=Puesto::find($request->id);
      $puesto->update($request->only('puesto','descripcion'));
      //$request->session()->flash('success', 'El puesto '.$puesto->puesto.' se actualizo satisfactoriamente');
      return  $puesto->toJson();//redirect('/herramientas/puestos');
    }

    
}
