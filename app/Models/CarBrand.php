<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CarBrand extends Model
{
    protected $table = 'car_brands';

    protected $fillable = [
        'name',
        'picture_uri',
        'created_at',
        'updated_at',
    ];

    public function parseForm($params)
    {
        return [
            'name' => $params['name'],
            'picture_uri' => isset($params['picture_uri']) ? $params['picture_uri'] : null
        ];
    }

    public function preDelete()
    {
        return DB::table('car_models')->where('brand_id', '=', $this->id)->delete();
    }

    public function validate($params)
    {
        $errors = [];
        $duplicated = DB::table('car_brands')
            ->where('name', $params['name'])
            ->where('id', '!=', $this->id || -1)
            ->count();

        if ($duplicated) {
            $errors[] = ['El nombre de la marca esta en uso'];
        }

        return $errors;
    }
}
