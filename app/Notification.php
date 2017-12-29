<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function receptor()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function emisor()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}
