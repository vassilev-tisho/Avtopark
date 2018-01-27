<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Vehicles extends Model
{

	protected $table		 = 'vehicles';
	protected $primaryKey	 = 'id';

	public function status()
	{
		return $this->hasOne('App\Status', 'id', 'vehicle_status_id');
		//                             _______     _____________          ____________________
        //                                 |              |                     |
        //                                   |            |                     |
        //                                    |           |         тук е id-то от модела, в който сме
        //                                     |          |
        //                                  тук е id-то от модела, който
        //                                      включваме
        //
        ////////////////////////////////////////////////////////////////////////////////////////
	}

	public function vehicle_types()
	{
		return $this->hasOne('App\Vehicle_types', 'id', 'vehicle_types_id');
	}

	public function vehicleRepair()
    {
        return $this->hasOne('App\VehicleRepair', 'vehicle_id', 'id');
    }

    public function logVehicles()
    {
        return $this->hasOne('App\LogVehicles', 'vehicle_id', 'id');
    }

	public function orders()
    {
        return $this->hasMany('App\Orders', 'vehicle_id', 'id');
    }

	public function create(\Illuminate\Http\Request $request)
	{
		$this->brand			 = $request->brand;
		$this->regNumber		 = $request->regNumber;
		$this->fuelType			 = $request->vehicle_engine;
		$this->vehicle_types_id	 = $request->vehicle_type;
		$this->vehicle_status_id = $request->vehicle_status_id;
		$this->fuelConsumption	 = $request->fuelConsumption;
		$this->mileage			 = $request->mileage;
		$this->chargeWeight		 = $request->chargeWeight;
		$this->insurance		 = $request->insurance;
		$this->technicalReview	 = $request->technicalReview;
		$this->driveLicenseNeed  = $request->driveLicenseNeed;
		$this->save();
	}

	public function searchFreeVehicles(Request $request)
    {
        $dateSearch = $request->orderSearchDate;
        $freeVehicles = VehicleReservation::whereDate('orderStartDate', '<=', Carbon::parse($dateSearch)->toDateString());
        dd($freeVehicles);
    }
}
