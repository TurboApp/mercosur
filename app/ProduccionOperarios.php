<?php

namespace App;



class ProduccionOperarios extends Model
{
    public function coordinacion(){
        return $this->hasOne('App\coordinacion','id','coordinacion_id');
    }

    public function fuerzaTarea(){
        return $this->hasOne('App\FuerzaTarea','id','fuerza_tarea_id');  
    }
}
