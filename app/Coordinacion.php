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
        return $this->hasOne('App\OrdenServicio','id','id_orden_servicio');
    }

    public function coordinador()
    {
        return $this->hasOne('App\User','id', 'coordinador_id');
    }
    
    public function supervisor()
    {
        return $this->hasOne('App\User','id', 'supervisor_id');
    }
}
