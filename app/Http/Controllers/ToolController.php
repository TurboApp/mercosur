<?php
namespace App\Http\Controllers;
use App\Perfil;
use App\Puesto;


use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(){
      return view('pages.herramientas.index');
    }

    public function create(){
      return view('pages.herramientas.create');
    }

    public function store(Request $request){
      if($request->perfil){
        $this->validate(request(),[
          'perfil' => 'required'
        ]);
        $pe=(new Perfil)->fill($request->all());
        $pe->save();
        $request->session()->flash('success', 'El perfil '.$pe->perfil.' se agrego a la base de datos satisfactoriamente');
        return redirect('/herramientas/nuevo');
      }
      else {
        $this->validate(request(),[
          'puesto' => 'required'
        ]);
        $pu=(new Puesto)->fill($request->all());
        $pu->save();
        $request->session()->flash('success', 'El puesto '.$pu->puesto.' se agrego a la base de datos satisfactoriamente');
        return redirect('/herramientas/nuevo');
      }
    }
}
