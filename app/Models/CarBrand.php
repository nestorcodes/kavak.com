<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    protected $table = 'car_brands';

    protected $fillable = [
        'name',
        'picture_uri',
        'created_at', 
        'updated_at',
    ];
}
