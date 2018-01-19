<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table="login";
    protected $fillable=['user','password'];

    public function users(){
      return $this->belongsTo('App\User');
    }

    public function perfil(){
      return $this->belongsTo('App\Perfil');
    }
}
