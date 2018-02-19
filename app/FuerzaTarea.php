<?php

namespace App;

class FuerzaTarea extends Model
{
  protected $table="fuerza_tareas";
  protected $fillable=['nombre','contacto','descripcion','categoria'];

  public function produccion(){
    return $this->hasMany('App\ProduccionOperarios','fuerza_tarea_id','id');
  }
}
