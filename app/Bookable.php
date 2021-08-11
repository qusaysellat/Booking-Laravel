<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookable extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function people()
    {
        return $this->belongsToMany('App\User', 'booked', 'bookable_id', 'user_id')->withPivot('day','status')->withTimestamps();
    }

    public function offers()
    {
        return $this->hasMany('App\Offer');
    }

}
