<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleReservation extends Model
{
    protected $table = 'vehicle_reservation';
    protected $primaryKey = 'id';

    public function order()
    {
        return $this->hasMany('App\Orders', 'order_id', 'id');
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $this->vehicle_id        = $request->vehicle;
        $this->driver_id         = $request->driver;
        $this->customer_id       = $request->customer_id;
        $this->orderStartDate    = $request->orderDate;
        $this->save();
    }
}
