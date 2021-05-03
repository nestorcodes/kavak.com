<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function parseForm($params)
    {
        return [
            'name' => $params['name'],
            'brand_id' => $params['brand']
        ];
    }

    public function validate($params)
    {
        $errors = [];
        $duplicated = DB::table('car_models')
            ->where('name', $params['name'])
            ->where('brand_id', $params['brand_id'])
            ->where('id', '!=', $this->id || -1)
            ->count();

        if ($duplicated) {
            $errors[] = ['El nombre del modelo esta en uso'];
        }

        return $errors;
    }

    public function getQuery()
    {
        return $this->leftJoin('car_brands', 'car_brands.id', 'car_models.brand_id')
            ->select('car_models.*', 'car_brands.name as brand');
    }
}
