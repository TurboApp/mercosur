<?php

namespace App;



class ServicioArchivo extends Model
{
    public function servicio()
    {
        return $this->belongsTo('App\Servicio','servicio_id','id');
    }
}
