<?php

namespace App;



class ServicioMercanciaDocumento extends Model
{
    public function servicio()
    {
        return $this->belongsTo('App\Servicio','servicio_id','documento_id');
    }
}
