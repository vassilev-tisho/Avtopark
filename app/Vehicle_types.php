<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle_types extends Model
{
//    const VEHICLE_TYPE_CAR      = "Car";
//    const VEHICLE_TYPE_BUS      = "Bus";
//    const VEHICLE_TYPE_TRUCK    = "Truck";

    protected $table = 'vehicle_types';
    protected $primaryKey = 'id';

    public function vehicles()
    {
        return $this->hasMany('App\Vehicles', 'vehicle_types_id', 'id');
    }
}
