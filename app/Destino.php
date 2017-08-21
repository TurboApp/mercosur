<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;

class Destino extends Model
{
    use SearchableTrait;
    
    protected $searchable = [
        'columns' => [
            'destinos.id' => 10,
            'destinos.nombre' => 5,
        ],
        // 'joins' => [
        //     'profiles' => ['users.id','profiles.user_id'],
        // ],
    ];
}
