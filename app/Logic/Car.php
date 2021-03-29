<?php

namespace App\Logic;

use App\Models\Car as CarModel;

use Illuminate\Support\Facades\DB;

class Car extends CarModel
{
    public static function getList($filter = [], $select = '')
    {
        if (empty($select)) {
            $select = "
                car_brands.name as brand,
                car_models.name as model,
                cars.id as code,
                cars.price
            ";
        }

        $Query = DB::table('cars')
            ->selectRaw($select)
            ->leftJoin('car_models', 'car_models.id', '=', 'cars.model_id')
            ->leftJoin('car_brands', 'car_brands.id', '=', 'car_models.brand_id');

        if (isset($filter['brand'])) {
            $Query->where('car_brands.id', '=', $filter['brand']);
        }

        if (isset($filter['model'])) {
            $Query->where('car_models.id', '=', $filter['model']);
        }

        // Mas Filtros

        return $Query;
    }
}
