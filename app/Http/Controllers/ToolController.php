<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\User;
use App\Puesto;
use App\Equipo;
use DataTables;

class ToolController extends Controller
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
        $request->session()->flash('success', 'El puesto '.$pu->puesto.' se agrego a la base de datos satisfactoriamente');
        return redirect('/herramientas/puestos');
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
      $request->session()->flash('success', 'El puesto '.$puesto->puesto.' se actualizo satisfactoriamente');
      return redirect('/herramientas/puestos');
    }

    ##Equipos
    public function createEquipo()
    {
      $equipos=Equipo::paginate(15);
      foreach($equipos as $equipo){
        $equipo['miembros'] = User::where('equipo_id',$equipo->id)->count();
      }
      return view('pages.herramientas.equipos',compact('equipos'));
    }

    public function storeEquipo(Request $request)
    {
      $this->validate(request(),[
        'nombre' => 'required|unique:equipos|max:199'
        ]);
      $equipo=(new Equipo)->fill($request->all());
      $equipo->save();
      $request->session()->flash('success', 'El Equipo '.$equipo->nombre.' se agrego a la base de datos satisfactoriamente');
      return redirect('/herramientas/equipos');
    }

    public function infoEquipo(Request $request)
    {
      $equipo = Equipo::find($request->id);
      return $equipo->toJson();
    }

    public function updateEquipo(Request $request)
    {
      $this->validate(request(),[
        'nombre' => ['required',Rule::unique('equipos')->ignore($request->id)],
        ]);
      $equipo = Equipo::find($request->id);
      $equipo->update($request->only('nombre','descripcion'));
      $request->session()->flash('success', 'El equipo '.$equipo->nombre.' se actualizo satisfactoriamente');
      return redirect('/herramientas/equipos');

    }
    public function showEquipo(Request $request)
    {
      $equipo = Equipo::find($request->id);
      if($equipo == null)
      {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/herramientas/equipos');
      }
      $equipo['numero_miembros'] = User::where('equipo_id',$equipo->id)->count();
      $equipo->miembros;
      return view('pages.herramientas.equipos-show', compact('equipo'));
    }
}
