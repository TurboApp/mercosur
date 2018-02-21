<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Equipo;
use App\User;

class EquipoController extends Controller
{
    ##Equipos
    public function createEquipo()
    {
      $equipos=Equipo::paginate(16);
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
