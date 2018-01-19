<?php

namespace App;



class ManiobraSubtareaAttachment extends Model
{
    public function tarea()
    {
        $this->belongsTo('App\ManiobraSubtarea', 'id','subtarea_id');
    }
}
