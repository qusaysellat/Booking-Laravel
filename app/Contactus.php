<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
