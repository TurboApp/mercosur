<?php

namespace App;

use Jenssegers\Date\Date;
class Coordinacion extends Model
{
    protected $dates = [
        'fecha_servicio',
    ];

    public function servicio()
    {
        return $this->belongsTo('App\Servicio','servicio_id', 'id');
    }

    public function coordinador()
    {
        return $this->hasOne('App\User','id', 'coordinador_id');
    }
    
    public function supervisor()
    {
        return $this->hasOne('App\User','id', 'supervisor_id');
    }

    public function supervisorActivo()
    {
        return $this->hasOne('App\supervisor_activo', 'coordinacion_id','id');
    }

    public function tareas(){
        return $this->hasMany('App\ManiobraTarea','coordinacion_id','id');
    }

}
