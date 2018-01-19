<?php

namespace App;


class Agente extends Model
{
 
    public function servicio()
    {
        return $this->hasMany('App\Servicio','agente_id','id');
    }
}
