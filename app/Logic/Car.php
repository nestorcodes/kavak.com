<?php

namespace App\Logic;

use App\Models\Car as CarModel;
use App\Models\UserFavoriteCar as FavoriteCarModel;
use Illuminate\Support\Facades\DB;

class Car extends CarModel
{
    public static function getViewParams()
    {
        return [
            'years' => DB::table('cars')->selectRaw("distinct(cars.year) as year")->orderBy('year', 'desc')->get(),
            'types' => DB::table('car_types')->select('id', 'name', 'picture_uri')->orderBy('name', 'asc')->get(),
            'brands' => DB::table('car_brands')->select('id', 'name', 'picture_uri')->orderBy('name', 'asc')->get(),
            'models' => DB::table('car_models')->select('id', 'name', 'brand_id')->orderBy('name', 'asc')->get(),
        ];
    }

    public static function getList($filter = [], $select = '')
    {
        if (empty($select)) {
            $select = "
                car_brands.name as brand,
                car_models.name as model,
                cars.id as code,
                cars.price,
                cars.picture_uri as image,
                cars.year as car_year,
                cars.transmission as trs,
                IF(user_favorite_cars.user_id IS NOT NULL, 1, 0) as favorite
            ";
        }

        $Query = DB::table('cars')
            ->selectRaw($select)
            ->leftJoin('car_models', 'car_models.id', '=', 'cars.model_id')
            ->leftJoin('car_brands', 'car_brands.id', '=', 'car_models.brand_id')
            ->leftJoin('user_favorite_cars', function ($j) {
                $j->on('cars.id', '=', 'user_favorite_cars.car_id');

                if (isset(auth()->user()->id)) {
                    $j->where('user_id', '=', auth()->user()->id);
                }
            });

        if (isset($filter['brand'])) {
            $Query->where('car_brands.id', '=', $filter['brand']);
        }

        if (isset($filter['model'])) {
            $Query->where('car_models.id', '=', $filter['model']);
        }

        if (isset($filter['year'])) {
            $Query->where('cars.year', '=', $filter['year']);
        }

        return $Query;
    }

    public static function makeFilter($input)
    {
        $Filter = [];

        $values = explode('&', $input);

        foreach($values as $pair) {
            $pair = explode('=', $pair);

            if (isset($pair[1]) && !empty($pair[1])) {
                $Filter[$pair[0]] = $pair[1];
            } else {
                $Filter[$pair[0]] = null;
            }
        }

        return $Filter;
    }

    public function setFavorite($status)
    {
        if ($status) {
            FavoriteCarModel::create([
                'user_id' => auth()->user()->id,
                'car_id'  => $this->id,
            ]);
        } else {
            FavoriteCarModel::where('user_id', '=', auth()->user()->id)
                ->where('car_id', '=', $this->id)->delete();
        }
    }
}
