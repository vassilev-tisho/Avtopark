<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';


    public function manager()
    {
        return $this->hasOne('App\User', 'id', 'manager_id');
    }

    public function customer()
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }
    public function driver()
    {
        return $this->hasOne('App\User', 'id', 'driver_id');
    }

    public function services()
    {
        return $this->hasOne('App\Services', 'id', 'services_id');
    }

    public function vehicles()
    {
        return $this->hasOne('App\Vehicles', 'id', 'vehicle_id');
    }

    public function orderStatus()
    {
        return $this->hasOne('App\OrderStatus', 'id', 'order_status_id');
    }

    public function vehicleReservation()
    {
        return $this->hasOne('App\VehicleReservation', 'id', 'order_id');
    }

//    protected $dates = [
//        'orderDate'
//    ];

//    protected function setOrderDateAttribute($value)
//    {
//        $this->attributes['orderDate'] = Carbon::createFromFormat(
//            $this->getDateFormat('orderDate'), $value
//        );
//    }

protected $softDelete = true;
    public function create(\Illuminate\Http\Request $request)
    {
        $this->services_id       = $request->services;
        $this->vehicle_id        = $request->vehicle;
        $this->driver_id         = $request->driver;
        $this->manager_id        = $request->manager;
        $this->addressSending    = $request->addressSending;
        $this->addressReceiver   = $request->addressReceiver;
        $this->kilometres        = $request->kilometres;
        $this->price             = $request->price;
        $this->customer_id       = $request->customer_id;
        $this->timeToArrive      = $request->time;
        $this->order_status_id   = OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_PROCESSING)->first()->id;
        $this->orderDate         = ($request->orderDate);
        $this->save();
    }

    public function createForCustomer(\Illuminate\Http\Request $request)
    {
        $this->services_id       = $request->services;
        $this->addressSending    = $request->addressSending;
        $this->addressReceiver   = $request->addressReceiver;
        $this->kilometres        = $request->kilometres;
        $this->price             = $request->price;
        $this->customer_id       = $request->customer_id;
        $this->order_status_id   = OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_NEW)->first()->id;
        $this->timeToArrive      = $request->time;
        $this->orderDate         = ($request->orderDate);
        $this->save();
    }

    public function getShortAddressSendingAttribute(){
        return substr($this->addressSending, 0, 30);
    }


    public function getShortAddressReceiverAttribute(){
        return substr($this->addressReceiver, 0, 30);
    }

//    public function calculatePriceOfOrder($id)
//    {
//        $order = Orders::find($id);
//        $vehicle = Vehicles::find($order->vehicle_id);
//
//        $driverSailary      = 2048;
//        $kilometresPerDay   = 10;
//        $businessTripPerDay = 20;
//
//        $vignette           = 130;
//        $insurance          = 1050;
//        $tehniclaPreview    = 80;
//        $vehicleCostsPerDay = ($vignette + $insurance +$tehniclaPreview)/12/22;
//
//        $fuelPricePerLiter  = 2.12;
//        $fuelCostForTrip    =($vehicle->fuelConsumption * $order->kilometres * 2 / 100 * $fuelPricePerLiter);
//
//        $timeToArrive = ceil(($order->timeToArrive / 60/$kilometresPerDay));
//
//        if($timeToArrive >1){
//            $driverCostForTrip = (($timeToArrive * $businessTripPerDay) +($driverSailary /22 * $timeToArrive));
//        }else{
//            $driverCostForTrip = ($timeToArrive  +($driverSailary / 22));
//        }
//
//        $totalCost = ($fuelCostForTrip + $vehicleCostsPerDay + $driverCostForTrip);
//        $road = $order->kilometres;
//
//        $price = $totalCost / $road *1.25 ;
//        return $price;
//    }
}
