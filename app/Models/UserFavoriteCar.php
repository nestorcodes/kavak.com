<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavoriteCar extends Model
{
    protected $table = 'user_favorite_cars';

    protected $fillable = [
        'user_id',
        'car_id',
        'created_at',
        'updated_at'
    ];

    public function User()
    {
        $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function Car()
    {
        $this->hasOne('App\Models\Car', 'id', 'car_id');
    }
}
