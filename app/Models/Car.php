<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';

    protected $fillable = [
        'status_id',
        'model_id',
        'type_id',
        'year',
        'creator_id',
        'buyer_id',
        'price',
        'color',
        'transmission',
        'motor',
        'traction',
        'details',
        'horse_power',
        'gas_type',
        'seats',
        'picture_uri',
        'created_at',
        'updated_at'
    ];

    public static $status = [
        0 => 'Inactivo',
        1 => 'Activo',
        2 => 'Vendido',
    ];

    public static $transmission = [
        0 => 'Estándar',
        1 => 'Automático',
    ];

    public static $gasTypes = [
        0 => 'Gasolina',
        1 => 'Electrica'
    ];

    public function Model()
    {
        return $this->belongsTo('App\Models\CarModel', 'model_id', 'id');
    }

    public function Owner()
    {
        return $this->belongsTo('App\Models\User', 'buyer_id', 'id');
    }

    public function Creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_id', 'id');
    }
}
