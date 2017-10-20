<?php

namespace App;

class Puesto extends Model
{
  protected $table="puestos";
  protected $fillable=['puesto','descripcion'];
  public function users(){
    return $this->belongsToMany('App\User')->using('App\UserPuesto');
  }
}
