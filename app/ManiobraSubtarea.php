<?php

namespace App;



class ManiobraSubtarea extends Model
{
    public function tarea()
    {
        return $this->hasOne('App\ManiobraTarea', 'id', 'tarea_id');
    }

    public function attachment()
    {
        return $this->hasMany('App\ManiobraSubtareaAttachment','subtarea_id','id');
    }
}
