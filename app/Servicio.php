<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    public static function getNumServicio()
    {
        if(Servicio::orderBy('servicio_id','desc')->first()){
            return OrdenServicio::orderBy('servicio_id','desc')->first()->id + 1;
        }else{
            return 1;
        }
    }
}
