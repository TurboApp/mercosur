<?php

namespace App;

use Jenssegers\Date\Date;

class OrdenServicio extends Model
{
    
    public function getTodayAttribute($date)
    {
        return new Date($date);
    }
}

