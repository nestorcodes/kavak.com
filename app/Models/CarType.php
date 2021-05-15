<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $table = 'car_types';
    protected $fillable = [
        'name',
        'picture_uri',
        'created_at',
        'updated_at',
    ];
}
