<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


use App\User;
use App\Perfil;
use App\Puesto;
use App\Login;
use App\UserPuesto;

class UserController extends Controller
{
    function __construct(){
      $this->middleware(['auth','perfils:Administrador']);
    }

    public function index(){
      $usuarios=User::all();
      return view('pages.usuarios.index',compact('usuarios'));
    }

    public function create(){
       $perfiles=Perfil::all();
       $puestos=Puesto::all();
       return view('pages.usuarios.create',compact('puestos','perfiles'));
    }

    public function store(Request $request){
      $this->validate($request,[
          'nombre' => 'required',
          'apellido' => 'required',
          'direccion' => 'required',
          'celular' => 'required',
          'id_puesto' => 'required',
          'perfil_id' => 'required',
          'user' => 'required|unique:users,user',
          'password' =>'required|min:6',
          'email' => 'nullable|email|unique:users,email',
          'url_avatar' => 'image',
      ]);

      $user=(new User)->fill($request->all());
      // dd($user);
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

    public function show(User $usuario){
      $perfil=$usuario->perfil;
      $puesto=$usuario->puestos;
      return view('pages.usuarios.show',compact('usuario'));
    }

    public function edit(User $usuario){
      $puesto=$usuario->puestos;
      $perfil=$usuario->perfil;
      $perfiles=Perfil::pluck('perfil','id');
      $perfiles=$perfiles->all();
      $puestos=Puesto::pluck('puesto','id');
      $puestos=$puestos->all();
      // $puestos=$puestos->toArray();
      // dd($puestos);
      return view('pages.usuarios.edit',array("id"=>$usuario->id,"usuario"=>$usuario,"perfiles"=>$perfiles,"puestos"=>$puestos));
    }

    public function update(Request $request, User $usuario){
      $this->validate($request,[
          'nombre' => 'required',
          'apellido' => 'required',
          'direccion' => 'required',
          'celular' => 'required',
          'id_puesto' => 'required',
          'id_perfil' => 'required',
          'user' => ['required',Rule::unique('users')->ignore($usuario->id)],
          'email' => ['nullable','email',Rule::unique('users')->ignore($usuario->id)],
          'url_avatar' => 'image',
      ]);

        $usuario=User::findOrFail($usuario->id);
        if($request->hasFile('url_avatar')){
          $usuario->url_avatar=$request->file('url_avatar')->store('public');
        }
        $usuario->update($request->only('nombre','apellido','email','direccion','telefono','celular','user','id_perfil'));
        $usuario->puestos()->sync($request->id_puesto);
        $request->session()->flash('success', 'El usuario '.$usuario->nombre.' se ha actualizado satisfactoriamente');
        return redirect('/usuarios/'.$usuario->id);
    }

    public function destroy(Request $request, User $usuario){
      //dd($user->id);
      $del=User::find($usuario->id);
      if (count($del)) {
        $del->delete();
      }
      $request->session()->flash('success', 'El usuario registro fue elimado');
    }
}
