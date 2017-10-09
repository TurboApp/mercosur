<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuerzaTarea extends Model
{
  protected $table="fuerza_tareas";
  protected $fillable=['nombre','apellido','direccion','telefono','celular','categoria'];
}
