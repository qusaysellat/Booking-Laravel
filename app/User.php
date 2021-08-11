<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function bookables()
    {
        return $this->hasMany('App\Bookable');
    }

    public function booked()
    {
        return $this->belongsToMany('App\Bookable', 'booked', 'user_id', 'bookable_id')->withPivot('day', 'status')->withTimestamps();
    }

    public function contactuses()
    {
        return $this->hasMany('App\Contactus');
    }

    public function brands()
    {
        return $this->belongsToMany('App\User', 'loyalty', 'user1_id', 'user2_id')->withPivot('value')->withTimestamps();
    }

    public function people()
    {
        return $this->belongsToMany('App\User', 'loyalty', 'user2_id', 'user1_id')->withPivot('value')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function verifyuser()
    {
        return $this->hasOne('App\VerifyUser');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
