<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class MiperfilController extends Controller
{
    public function show(){
      return view('pages.perfiles.show');
    }

    public function edit(User $user){
      return view('pages.perfiles.edit',compact('user'));
    }

    public function update(Request $request, User $user){
      $this->validate($request,[
          'nombre' => 'required',
          'apellido' => 'required',
          'direccion' => 'required',
          'celular' => 'required|max:20',
          'telefono' => 'nullable|max:20',
          'password'  => 'nullable|min:6',
          'email' => ['nullable','email',Rule::unique('users')->ignore($user->id)],
          'url_avatar' => 'image',
      ]);

      if (!empty($request->password_actual)) {
        if (Hash::check( $request->password_actual, Auth::user()->password )) {
          $user->password =  
          $user->save();
        }
        else {
          return redirect('/perfil/'.$user->id.'/editar')->withErrors('La Contraseña Actual no es correcta');
        }
      }

      if($request->hasFile('url_avatar')){
        $user->url_avatar=$request->file('url_avatar')->store('public');
      }

      $user->update($request->only('nombre','apellido','email','direccion','telefono','celular'));

      $request->session()->flash('success', 'Su perfil de '.$user->nombre.' se ha actualizado satisfactoriamente');
      return redirect('/perfil/'.$user->id);
    }
}
