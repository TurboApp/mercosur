<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;


class User extends Model implements Authenticatable
{
  use \Illuminate\Auth\Authenticatable;
  use Notifiable;
  protected $guard="users";
  protected $fillable=['nombre','apellido','email','direccion','telefono','celular','url_avatar','user','password','perfil_id'];
  protected $hidden = [
        'password', 'remember_token',
    ];

  public function puestos(){
    return $this->belongsToMany('App\Puesto','user_puesto','id_usuario','id_puesto');
  }

  public function perfil(){
    return $this->belongsTo('App\Perfil');
  }

  public function hasPerfils(array $perfiles)
  {
    foreach ($perfiles as $perfil) {
      if ($this->perfil->perfil === $perfil) {
        return true;
      }
    }
    return false;
  }

}
