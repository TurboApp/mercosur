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
        // 'joins' => [
        //     'profiles' => ['users.id','profiles.user_id'],
        // ],
    ];
    
}
