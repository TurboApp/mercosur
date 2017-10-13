<?php

namespace App;


class Coordinacion extends Model
{
    public function servicio()
    {
        return $this->hasOne('App\OrdenServicio','id','id_orden_servicio');
    }
}
