<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleRepair extends Model
{
    protected $table = 'vehicle_repair';
    protected $primaryKey = 'id';

    protected $fillable = [
        'vehicle_id', 'dateInRepair', 'dateOutRepair', 'serviceName', 'repairType', 'price'
    ];
    public function vehicles()
    {
        return $this->hasMany('App\Vehicles', 'id', 'vehicle_id');
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $this->vehicle_id       =   $request->vhid;
        $this->dateInRepair     =   $request->dateInRepair;
        $this->dateOutRepair    =   $request->dateOutRepair;
        $this->serviceName      =   $request->serviceName;
        $this->repairType       =   $request->repairType;
        $this->price            =   $request->price;
        $this->save();

    }
}
