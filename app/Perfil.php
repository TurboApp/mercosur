<?php

namespace App;


class Perfil extends Model
{
  protected $table="perfils";

  protected $fillable=['perfil','descripcion'];

  public function users(){
    return $this->hasMany('App\Perfil');
  }

}
