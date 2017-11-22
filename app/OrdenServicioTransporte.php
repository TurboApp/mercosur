<?php

namespace App;



class OrdenServicioTransporte extends Model
{
    public function servicio()
    {
        return $this->belongsTo('App\OrdenServicio','id_orden_servicio','id');
    }

    
    public function transporte(){
         return $this->belongsTo('App\LineasTransporte','id_linea_transporte','id');  
    }
}
