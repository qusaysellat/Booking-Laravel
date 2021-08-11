<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function bookable()
    {
        return $this->belongsTo('App\Bookable');
    }
}
