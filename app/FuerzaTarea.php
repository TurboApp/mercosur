<?php

namespace App;

class FuerzaTarea extends Model
{
  protected $table="fuerza_tareas";
  protected $fillable=['nombre','contacto','descripcion','categoria'];
}
