<?php

namespace App;



class Equipo extends Model
{
    public function miembros()
    {
        return $this->hasMany('App\User','equipo_id','id');
    }

    

}
