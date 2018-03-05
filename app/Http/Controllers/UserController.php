<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Equipo;
use App\Perfil;
use App\Puesto;
use App\Login;
use App\UserPuesto;

class UserController extends Controller
{
    function __construct(){
      $this->middleware(['auth','perfils:admin,go,directivo']);
    }

    public function index(){
      $usuarios=User::latest()->paginate(15);
      return view('pages.usuarios.index',compact('usuarios'));
    }

    public function create(){
        $perfiles=Perfil::all();
        $puestos=Puesto::all();
        $equipos=Equipo::all();
      return view('pages.usuarios.create',compact('puestos', 'perfiles', 'equipos'));
    }

    public function store(Request $request){
     //dd($request->all());
      $this->validate($request,[
          'nombre' => 'required',
          'apellido' => 'required',
          'direccion' => 'required',
          'celular' => 'required',
          'id_puesto' => 'required',
          'perfil_id' => 'required',
          //'equipo_id' => 'required',
          'user' => 'required|unique:users,user',
          'password' =>'required|min:6',
          'email' => 'nullable|email|unique:users,email',
          'url_avatar' => 'image',
      ]);

      $user=(new User)->fill($request->all());
      
      if($request->hasFile('url_avatar')){
        $user->url_avatar=$request->file('url_avatar')->store('public');
      }
      $user->password=bcrypt($request->password);
      $user->save();
      $user->puestos()->attach($request->id_puesto,['id_usuario'=>$user->id]);
      $request->session()->flash('success', 'El usuario '.$user->user.' se agrego a la base de datos satisfactoriamente');
      return redirect('/usuarios/');
    }

    // public function show(){
    //
    // }

    public function show(Request $request, $usuario){
      $usuario=User::find($usuario);
      
      if ($usuario==null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/usuarios/');
      } else {
        $perfil=$usuario->perfil;
        $puesto=$usuario->puestos;
       
        return view('pages.usuarios.show',compact('usuario'));
      }

    }

    public function showSupervisor(Request $request, $supervisor){
      $usuario=User::find($supervisor);
      if ($usuario==null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/supervisores/');
      } else {
        $perfil=$usuario->perfil;
        $puesto=$usuario->puestos;
        return view('pages.productividad.supervisores.info',compact('usuario'));
      }

    }

    public function showCoordinador(Request $request, $coordinador){
      $usuario=User::find($coordinador);
      if ($usuario==null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/supervisores/');
      } else {
        $perfil=$usuario->perfil;
        $puesto=$usuario->puestos;
        return view('pages.productividad.coordinadores.info',compact('usuario'));
      }

    }

    public function edit(Request $request, $usuario){
      $usuario = User::find($usuario);
      if ($usuario==null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/usuarios/');
      } else {
        $puesto  = $usuario->puestos;
        $puestos = Puesto::pluck('puesto','id');
        $puestos = $puestos->all();

        //$perfil   = $usuario->perfil;
        $perfiles = Perfil::all();

        $equipoUsuario  = $usuario->equipo;
        $equipos = Equipo::all();
        //$equipos = $equipos->all();

        //dd($usuario->equipo);
        // $puestos=$puestos->toArray();
        // dd($puestos);
        return view('pages.usuarios.edit',array("id"=>$usuario->id,"usuario"=>$usuario,"perfiles"=>$perfiles,"puestos"=>$puestos,"equipos"=>$equipos));
      }

    }

    public function update(Request $request, User $usuario){
      
      $this->validate($request,[
          'nombre' => 'required',
          'apellido' => 'required',
          'direccion' => 'required',
          'celular' => 'required',
          'id_puesto' => 'required',
          'perfil_id' => 'required',
          //'equipo_id' => 'required',
          'user' => ['required',Rule::unique('users')->ignore($usuario->id)],
          'email' => ['nullable','email',Rule::unique('users')->ignore($usuario->id)],
          'url_avatar' => 'image',
          'password' => 'nullable|min:6' 
      ]);

      $usuario = User::findOrFail($usuario->id);
      
      $usuario->update($request->only('nombre','apellido','email','direccion','telefono','celular','user'));

      $usuario->perfil_id = $request->perfil_id;
      $usuario->save();  
      
      if( $request->equipo_id && $request->perfil_id > 3 ){
        $usuario->equipo_id = $request->equipo_id;
        $usuario->save();  
      }else{
        $usuario->equipo_id = Null;
        $usuario->save();  
      }
      
      if( $request->password ){
          $usuario->password = Hash::make($request->password) ;
          $usuario->save();
      }

      $usuario->puestos()->sync($request->id_puesto);
      $request->session()->flash('success', 'El usuario '.$usuario->nombre.' se ha actualizado satisfactoriamente');
      return redirect('/usuarios/'.$usuario->id);
    }

    public function destroy(Request $request, User $usuario){
      $del=User::find($usuario->id);
      if (count($del)) {
        $del->delete();
      }
      $request->session()->flash('success', 'El registro fue elimado');
    }

    public function search(Request $request)
   {
       $usuarios = User::where('nombre', 'LIKE','%'.$request->s.'%')->orWhere('apellido', 'LIKE','%'.$request->s.'%')->paginate(15);
       $usuarios->appends( [ 's' => $request->s ] );

       return view('pages.usuarios.search', compact('usuarios','request'));
   }
}
