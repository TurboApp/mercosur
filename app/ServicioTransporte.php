<?php

namespace App;



class ServicioTransporte extends Model
{
    public function servicio()
    {
        return $this->belongsTo('App\Servicio','servicio_id','transporte_id');
    }

    
    public function transporte(){
         return $this->belongsTo('App\LineasTransporte','linea_transporte_id','id');  
    }
}
