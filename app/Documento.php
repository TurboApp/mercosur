<?php

namespace App;



class Documento extends Model
{
    public function servicio()
    {
        return $this->belongsTo('App\OrdenServicio','id_orden_servicio','id');
    }
}
