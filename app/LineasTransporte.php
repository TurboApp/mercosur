<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;

class LineasTransporte extends Model
{
    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'lineas_transportes.id' => 10,
            'lineas_transportes.nombre' => 5,
            'lineas_transportes.nombre_corto' => 3,
        ],
    ];

    public function ordenservicios()
    {
        return $this->hasMany('App\ServicioTransporte','linea_transporte_id','id');
    }
    
}
