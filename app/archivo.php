<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class archivo extends Model
{
    public function servicio()
    {
        return $this->belongsTo('App\OrdenServicio','id_orden_servicio','id');
    }
}
