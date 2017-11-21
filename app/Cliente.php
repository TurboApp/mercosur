<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;

class Cliente extends Model
{
    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'clientes.id' => 10,
            'clientes.nombre' => 5,
            'clientes.rfc' => 3,
            
        ],
    ];
    

    public function servicio()
    {
        return $this->hasMany('App\Servicio','cliente_id','id');
    }
}
