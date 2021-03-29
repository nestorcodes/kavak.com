<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_models';

    protected $fillable = [
        'name',
        'brand_id',
        'created_at',
        'updated_at',
    ];

    public function Brand()
    {
        return $this->belongsTo('App\Models\CarBrand', 'brand_id', 'id');
    }
}
