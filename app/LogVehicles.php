<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogVehicles extends Model
{
    protected $table = 'logvehicle';
    protected $primaryKey = 'id';

    public function vehicles()
    {
		//
        return $this->hasMany('App\Vehicles', 'id', 'vehicle_id');
    }

    public function create($vehicleId, $message)
    {
        $this->vehicle_id   = $vehicleId;
        $this->message      = $message;
        $this->date         = \Carbon\Carbon::now();

        $this->save();
    }
    public function getShortMessageAttribute(){
        return substr($this->message, 0, 30);
    }
}
