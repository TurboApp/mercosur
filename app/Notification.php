<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function receptor()
    {
        return $this->hasOne('App\User','id','receptor_id');
    }

    public function emisor()
    {
        return $this->hasOne('App\User','id','emisor_id');
    }
}
