<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\LogVehicles;
use App\Orders;
use App\OrderStatus;
use App\Status;
use App\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{

    /*
     * Зареждане на началната страница на шофьора, и
     * показване на списък с назначените му задачи
     *
    */
	public function index()
	{
        $driver      = Auth::user();
        $closedId    =  OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_CLOSED)->first()->id;
        $orders      = Orders::where('driver_id', '=', $driver->id)
            ->where('order_status_id', '<>', $closedId)
            ->get();
		return view('driver.pages.index')
            ->with('orders', $orders);
	}

	/*
	 * Стартиране на изпълнението на поръчка
	 *
	*/
	public function startOrder(Request $request)
    {
        $logVehicle = new LogVehicles();

        /*
         * Взимам тази поръчка, пристигнала от рекуеста,
         * променям статуса и на "изпратена" и запазвам поръчката
         *
        */
        $order = Orders::find($request->orderId);
        $order->order_status_id = OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_SENT)->first()->id;
        $order->save();

        /*
         * Взимам МПС-то идващо от рекуеста и
         * променям статуса му на "На път"
         *
        */
        $vehicle = Vehicles::find($order->vehicle_id);
        $vehicle->vehicle_status_id = 2;


        $vehicle->save();
        $request->session()->flash('alert-success', 'Успешно и безаварийно пътуване!');

        /*
         * Записвам събитието в таблицата 'logVehicle'
        */
        $message= 'Изпращане на МПС на път '  . ' ' . $order->services->name . ' Шофьор : '
            . ' ' . $order->driver->fullName . ' Разстояние '
            . ' ' . $order->kilometres;

        //dd($vehicle->id);
        //$logVehicle->create($vehicle->vehicle_id, $message);
        $logVehicle->create($vehicle->id, $message);
        return redirect()->route('driver');
    }

    /*
     * Край на изпълнение на поръчката
     *
    */
    public function endOrder(Request $request)
    {

        $logVehicle = new LogVehicles();

        /*
         * Взимам поръчката от рекуеста и
         * сменям статуса и на "Приключена"
         *
        */
        $order = Orders::find($request->orderId);
        $order->order_status_id = OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_CLOSED)->first()->id;

        /*
         * МПС-то изпълнило поръчката трябва да се освободи
         * за да може да поема други поръчки.
         * Взимам неговото id от таблицата с поръчките и променям
         * статуса му на свободен.
         *
         * Добавям километрите изминати през маршрута, към общите
         * километри на МПС-то, от както е зачислено в автопарка.
         *
         * Записвам промените
        */
        $vehicle = Vehicles::find($order->vehicle_id);
        $vehicle->vehicle_status_id = 1;
        $vehicle->mileage += $order->kilometres;
        $vehicle->save();

        /*
         * Записвам събитието в таблица 'logvehicle'
        */
        $message= 'Изпълнена поръчка '  . ' ' . $order->services->name . ' Шофьор : '
            . ' ' . $order->driver->fullName . ' Разстояние '
            . ' ' . $order->kilometres;

        //dd($vehicle->id);
        //$logVehicle->create($vehicle->vehicle_id, $message);
        $logVehicle->create($vehicle->id, $message);
        $order->driver_id = NULL;

        $order->save();
        $request->session()->flash('alert-success', 'Успешно приключихте поръчка!');



        return redirect()->route('driver');
    }
}
