<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'vehicle_status';
    protected $primaryKey = 'id';

    const STATUS_FREE = 'Free';
    const STATUS_ON_ROAD = 'OnRoad';
    const STATUS_ON_REPAIR = 'OnRepair';
    public function vehicles()
    {
        return $this->hasMany('App\Vehicles', 'status_id', 'id');
    }
}
