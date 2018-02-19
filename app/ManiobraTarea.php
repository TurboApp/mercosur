<?php

namespace App;


class ManiobraTarea extends Model
{
    public function coordinacion(){
        return $this->hasOne('App\Coordinacion', 'id' ,'coordinacion_id');
    }

    public function subTareas(){
        return $this->hasMany('App\ManiobraSubtarea', 'tarea_id','id');
    }

}
