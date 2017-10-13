<?php

namespace App;


class Agente extends Model
{
 
    public function servicio()
    {
        return $this->hasMany('App\OrdenServicio','agente_id','id');
    }
}
