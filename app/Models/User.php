<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [

    ];

    public function SellingCars()
    {
        $this->hasMany('App\Models\Car', 'id', 'creator_id');
    }

    public function OwnedCars()
    {
        $this->hasMany('App\Models\Car', 'id', 'buyer_id');
    }

    public function FavoriteCars()
    {
        $this->hasMany('App\Models\UserFavoriteCar', 'id', 'user_id');
    }
}
