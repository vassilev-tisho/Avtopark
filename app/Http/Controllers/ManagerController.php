<?php

namespace App\Http\Controllers;

use App\LogVehicles;
use App\OrderStatus;
use App\User;
use App\VehicleRepair;
use Illuminate\Http\Request;
use App\Vehicles;
use App\Http\Requests\VehicleFormRequest;
use App\Orders;
use App\Status;
use App\Role;
use App\VehicleReservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrdersFormRequest;
use App\Http\Requests\OrderEditRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ManagerController extends Controller
{

	public function index()
	{
	    $orders   = Orders::get();
	    $vehicles = \App\Vehicles::get();
		return view('manager.pages.index')
            ->with('orders', $orders)
            ->with('vehicles', $vehicles);
	}


	//Форма за добавяне на МПС
	public function createVehicle()
	{
        $vehicleStatuses = \App\Status::get();
        $vehicleTypes	 = \App\Vehicle_types::get();

        return view('manager.pages.create-vehicle')
				->with('vehicleTypes', $vehicleTypes)
				->with('vehicleStatuses', $vehicleStatuses);
	}


	/*
	 * Добавяне на МПС в автопарка
	*/
	public function storeVehicle(VehicleFormRequest $request)
	{
        $vehicle = new Vehicles();

        $vehicle->create($request);

        $logVehicle = new LogVehicles();

        $logVehicle->vehicle_id = $vehicle->id;

        /*
         * Записване на събитието в таблица 'logvehicle'
        */
        $logVehicle->message = 'Добавяне на ново МПС';
        $logVehicle->date = \Carbon\Carbon::now();
        $logVehicle->save();

        $request->session()->flash('alert-success', 'Успешно добавихте превозното средство!');

		return redirect()->route('show-vehicles');
	}


	//Показване на всички МПС-та в автопарка
	public function showVehicles()
	{
		$vehicles = Vehicles::all();

		return view('manager.pages.vehicles')->with('vehicles', $vehicles);
	}


	// Изтриване на МПС
	public function deleteVehicle($id, Request $request)
	{
        $logVehicle = new LogVehicles();
        $logVehicle->vehicle_id = Vehicles::find($id)->id;
        $logVehicle->message = 'Бракуване на  МПС';
        $logVehicle->date = \Carbon\Carbon::now();
        $logVehicle->save();

        Vehicles::find($id)->delete();
        $request->session()->flash('alert-success', 'Успешно изтрихте превозно средство!');
		return redirect()->route('show-vehicles');
	}


	/*
	 * Редакция на съществуващо МПС
	 *
	*/
	public function editVehicle($id)
	{
		$vehicle		 = Vehicles::findOrFail($id);
		$vehicleTypes	 = \App\Vehicle_types::get();
		$vehicleStatuses = \App\Status::get();
        $brokenVehicle   = new VehicleRepair();
        $oldStatus       = $vehicle->status_id;
        /*
                Така ще се взима времето и ще се сравняват датите :
             * $nowInSofia = Carbon::now('Europe/Sofia');
            $logTime = new \DateTime($log->date);
            $diff = $nowInSofia->diff($logTime);
            dd($diff->days +1);
         */


        $vehicleRepairData = array(
            'dateInRepair'   => '',
            'serviceName'    => '',
            'repairType'     => '',
            'dateOutRepair'  => '',
            'price'          => '',
        );
        $vehicleRepair = $vehicle->vehicleRepair()->whereNull('dateOutRepair')->first();

        if($vehicleRepair != null){
            $vehicleRepairData = array(
                'dateInRepair'   => $vehicleRepair->dateInRepair,
                'serviceName'    => $vehicleRepair->serviceName,
                'repairType'     => $vehicleRepair->repairType,
                'dateOutRepair'  => $vehicleRepair->dateOutRepair,
                'price'          => $vehicleRepair->price,
            );

        }


		return view('manager.pages.edit-vehicle')
				->with('vehicle', $vehicle)
				->with('vehicleTypes', $vehicleTypes)
				->with('vehicleStatuses', $vehicleStatuses)
                ->with('brokenVehicle', $brokenVehicle)
                ->with('oldStatus', $oldStatus)
                ->with('vehicleRepairData', $vehicleRepairData);
	}

	/*
	 * Запазване на промените за МПС, след редакция
	 *
	*/
	public function saveVehicle($id, VehicleFormRequest $request)
    {
        $vehicle = Vehicles::find($id);

        $logVehicle = new LogVehicles();

        if($vehicle->vehicleRepair()->whereNull('dateOutRepair')->first() == null){

            $newStatusCode = Status::find($request->get('vehicle_status_id'))->type;

            if($newStatusCode== Status::STATUS_ON_REPAIR){

                $brokenVehicle = new VehicleRepair();
                $brokenVehicle->create($request);

                $logVehicle->vehicle_id = Vehicles::find($id)->id;
                $logVehicle->message = 'Изпращане на МПС в сервиз ' . $brokenVehicle->serviceName;
                $logVehicle->date = $request->dateInRepair;
                $logVehicle->save();
            }


        }else{
            $brokenVehicle =  $vehicle->vehicleRepair()->whereNull('dateOutRepair')->first();

            $logOutRepair = false;
            if($brokenVehicle->dateOutRepair ==  '' && $request->dateOutRepair != ''){
                $logOutRepair = true;


            }
            foreach ($brokenVehicle->getFillable() as $k => $v)
            {
                if (isset($request->$v))
                {
                    $brokenVehicle->$v = $request->$v;
                }
            }
            $brokenVehicle->save();

            if($logOutRepair){
                $logVehicle->vehicle_id = $vehicle->id;
                $logVehicle->message = 'Oтремонтиране на МПС -'. $vehicle->brand. ' - ' .$vehicle->regNumber. ' от сервиз ' . $brokenVehicle->serviceName;
                $logVehicle->date = $request->dateOutRepair;
                $logVehicle->save();
            }

        }
//

        foreach ($vehicle->getAttributes() as $k => $v)
		{
			if (isset($request->$k))
			{
				$vehicle->$k = $request->$k;
			}
		}
		$vehicle->save();

		$request->session()->flash('alert-success', 'Успешно редактирахте превозно средство!');
        return redirect()->route('show-vehicles', ['id' => $id]);
	}


	/*
	 *
	 * Профил на МПС
	 * Когато искам да запиша някакво събитие свързано с използване МПС,
	 * правя инстанция на класа LogVehicles, викам метода vehicleProfile($id), който връща списък
	 * с всички събития за това МПС
	*/
	public function vehicleProfile($id)
    {
        $vehicle = Vehicles::findOrFail($id);

        $brokenVehicles = $vehicle->logVehicles()->orderBy('created_at', 'desc')->get();

        return view('manager.pages.vehicle-profile')
            ->with('vehicle', $vehicle)
            ->with('brokenVehicles', $brokenVehicles);
    }

    /*
	 * Досие за ремонти
	 * идентично с vehicleProfile($id)
	 *
	*/
    public function vehicleRepairProfile($id)
    {
        $vehicle = Vehicles::findOrFail($id);
        $brokenVehicles = $vehicle->vehicleRepair()->orderBy('created_at', 'desc')->get();
        return view('manager.pages.vehicle-repair-profile')
            ->with('vehicle', $vehicle)
            ->with('brokenVehicles', $brokenVehicles);
    }

    //Показване на всички поръчки
    public function showOrders()
    {
        return view('manager.pages.orders.orders')->with('orders', Orders::all());
    }


    /*
     * Форма за създаване на поръчка
     *
    */
	public function createOrder()
    {

        $drivers = User::query()
            ->join('roles', 'roles.id', '=', 'role_id')
            ->leftJoin('orders', 'driver_id', '=', 'users.id')
            ->whereNull('orders.id')
//            ->Where('order_status_id', '<>',
//                $closedOrderId = OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_CLOSED)->first()->id3)
            ->where('roles.code', '=', Role::ROLE_DRIVER)
            ->get(['users.*']);

        $services           = \App\Services::get();
        $vehicles           = \App\Vehicles::get();
        $managers           = \App\User::get();
        $orderStatus        = \App\OrderStatus::get();
        $vehicleReservation = \App\VehicleReservation::get();

        $customers = User::whereHas('role', function ($query) {
            $query->where('code', '=', Role::ROLE_CUSTOMER);
        })->get();


        $freeVehicles = Vehicles::whereHas('status', function ($query) {
            $query->where('type', '!=', Status::STATUS_ON_REPAIR);
        })->get();

        return view('manager.pages.orders.create-order')
            ->with('services', $services)
            ->with('vehicles', $vehicles)
            ->with('drivers', $drivers)
            ->with('managers', $managers)
            ->with('customers', $customers)
            ->with('orderStatus', $orderStatus)
            ->with('freeVehicles', $freeVehicles)
            ->with('vehicleReservation', $vehicleReservation);
    }


    /*
     * Записване на поръчка
    */
    public function storeOrder(OrdersFormRequest $request)
    {
        $order = new Orders();
        // функцията create($request) създава самата поръчка
        // описана е в модела Orders
        $order->create($request);
        $vehicleReservation = new VehicleReservation();

        /*
         * След като поръчката е създадена, взимам id-то
         * на колата или камиона и проверявам дали в таблицата 'vehicles'
         * съществува такова МПС с това id,
         * Ako e така му слагам статус "Ресервиран"
         *
         *
        */
        $vehicleID                      = $order->vehicle_id;
        $vehicle                        = Vehicles::find($vehicleID);
        $vehicle->vehicle_status_id     = 4;
      //  $vehicle->mileage              += $order->kilometres;
        $vehicle->save();

        /*
         * В таблиците с резервациите, полето order_id приема стойност на id-то на самата поръчка
         * Записва се началната дата
         * Пресмята се датата на пристигане
         * Викам функцията create($request), koято създава запис в таблицата 'vehicle_reservation'
         *
        */
        $vehicleReservation->order_id   = $order->id;
        $timeTest                       = $order->orderDate;
        $carbon_date                    = Carbon::parse($timeTest);
        $carbon_date2                   = $carbon_date->addHours($order->timeToArrive );
        //2018-01-09 17:00:00.000000
        /*Добавям времето за пристигане, което е 440 минути :
            и се получава :
        2018-01-09 22:00:00.000000
            2018-01-23 22:00:00.000000
         * */
        //2018-01-16 21:43:00.000000

        $vehicleReservation->orderStartDate = Carbon::parse($order->orderDate);
        $vehicleReservation->orderEndDate   = $vehicleReservation->orderStartDate->addHour($order->timeToArrive);
        $vehicleReservation->create($request);

        $request->session()->flash('alert-success', 'Успешно добавихте Поръчка!');

        return redirect()->route('show-orders');
    }


    /*
     * Редактиране на поръчка
    */
    public function editOrder($id)
    {
        $order = Orders::findOrFail($id);
        $services = \App\Services::get();
        $vehicles  = \App\Vehicles::get();
        $managers  = \App\User::get();
        $vehicleReservation =  \App\VehicleReservation::get();
        $vehicleReservation->order_id   = $order->id;
        $timeTest                       = $order->orderDate;
        $carbon_date                    = Carbon::parse($timeTest);
        $carbon_date2                   = $carbon_date->addHours($order->timeToArrive );
        //2018-01-09 17:00:00.000000
        /*Добавям времето за пристигане, което е 440 минути :
            и се получава :
        2018-01-09 22:00:00.000000
            2018-01-23 22:00:00.000000
         * */
        //2018-01-16 21:43:00.000000

        $vehicleReservation->orderStartDate = Carbon::parse($order->orderDate);
        $vehicleReservation->orderEndDate   = $vehicleReservation->orderStartDate->addHour($order->timeToArrive);

        //списък на всички клиенти
        $customers  = User::whereHas('role', function ($query) {
            $query->where('code', '=', Role::ROLE_CUSTOMER);
        })->get();

        //списък на свободните МПС-та
        $freeVehicles = Vehicles::whereHas('status', function ($query) {
            $query->where('type', '<>', Status::STATUS_ON_REPAIR);
        })->get();

        //списък на шофьорите
        $drivers = User::whereHas('role', function ($query) {
            $query->where('code', '=', Role::ROLE_DRIVER);
        })->get();
        return view('manager.pages.orders.edit-order')
            ->with('order', $order)
            ->with('services', $services)
            ->with('vehicles', $vehicles)
            ->with('drivers', $drivers)
            ->with('managers', $managers)
            ->with('customers', $customers)
            ->with('freeVehicles', $freeVehicles)
            ->with('vehicleReservation', $vehicleReservation);
    }


    /*
     * Запазване на поръчка
    */
    public function saveOrder($id, Request $request)
    {
        $order      = Orders::find($id);
        if($order->vehicle_id != null &&  $order->order_status_id == OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_PROCESSING)->first()->id){
            $vehicleReservation = VehicleReservation::where('vehicle_id', '=', $order->vehicle_id)
                ->where('order_id', '=', $order->id)->first();
        }else{
            $vehicleReservation = new VehicleReservation();
        }
        //dd($vehicleId, $order, $vehicle);
        foreach ($order->getAttributes() as $k=>$v)
        {
            if(isset($request->$k))
            {
                $order->$k = $request->$k;
            }
        }

        //1. проверявам дали колата вече е резервирана
        // 1.1 проверявам дали с това id на поръчката и id-то на колата и за дадената дата има запис в базата.
        // object if(object == null), ако е истина значи вече е резервирано. object->dateSent = $request->dateSent; object->save();
        // 1.2if (object == null), ако не е истина значи колата не е резервирана за тази поръчка.
        //    1.3      Тогава проверявам дали за избраната дата е резервирана колата
        //       1.4           if (object2 == null), ако е истина значи няма резервация
        //          1.5               тогава проверявам дали стария статус е Нова поръчка и новия статус е Одобрена
        //                              ако 1.5 е истина  му давам ->create()
        //                                      , ако 1.4 не е истина значи има резервация за тази дата, връща грешка
        //
//
        //ако поръчката не е вързана към мениджър
        if($order->manager == null){
            // да се свърже с този който записва промените
            $order->manager_id = Auth::user()->id;
            //слaга се статуса да е обработва се
            $order->order_status_id = OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_PROCESSING)->first()->id;

        }

        /*
         * Взимам id-то на колата от поръчката, слагам и статус "резервирана",
         * добавям километрите от поръчката към изминатите километри от колата
        */

        $vehicleID                      = $order->vehicle_id;
        $vehicle                        = Vehicles::find($vehicleID);
        $vehicle->vehicle_status_id     = 4;
        $vehicle->mileage              += $order->kilometres;

        /*
         * В таблицата с резервациите, добавям id-то на поръчката.
         * записвам датата на поръчката, която в тази таблица ще бъде, начало на поръчката.
         * пресмятам колко време ще продължи цялата поръчка, полученото време се добавя към
         * началото на поръчката и се получава времето за пристигане на поръчката
         *
        */
        $vehicleReservation->order_id   = $order->id;
        $timeTest                       = $order->orderDate;
        $carbon_date                    = Carbon::parse($timeTest);
        $carbon_date2                   = $carbon_date->addHours($order->timeToArrive );
        //2018-01-09 17:00:00.000000
        /*Добавям времето за пристигане, което е 440 минути :
            и се получава :
        2018-01-09 22:00:00.000000
            2018-01-23 22:00:00.000000
         * */
        //2018-01-16 21:43:00.000000



        /*
         * Извличам всички коли от таблицата с резервациите и проверявам, дали вече
         * няма запис в таблицата с тази кола.
         *  1. Ако е така -> грешка
         *  2. Ако не -> запис в таблицата
         *
        */
        $ifVehicleIsReserved                = VehicleReservation::where('vehicle_id', '=', $order->vehicle_id)
            ->where('order_id', '<>', $order->id)
            ->whereDate('orderStartDate', '<=', Carbon::parse($timeTest)->toDateString())
            ->whereDate('orderEndDate', '>=', Carbon::parse($timeTest)->toDateString())->first();

        if($ifVehicleIsReserved != null){
            $request->session()->flash('alert-error', 'Това превозно средство вече е резервирано за посочената дата!');
            return redirect()->route('edit-order', ['id' => $id]);
        }

        $vehicleReservation->orderStartDate = Carbon::parse($order->orderDate);
        $vehicleReservation->orderEndDate   = $vehicleReservation->orderStartDate->addHour($order->timeToArrive);
        $vehicleReservation->vehicle_id     = $order->vehicle_id;
        $vehicleReservation->driver_id      = $order->driver_id;
        $vehicleReservation->customer_id    = $order->customer_id;



        $order->save();
        $vehicleReservation->save();
        $vehicle->save();

        $request->session()->flash('alert-success', 'Успешно добавихте поръчка!');

        return redirect()->route('show-orders', ['id' => $id]);
    }



    /*
     * Изтриване на поръчка
     * Преди да се изтрие поръчка, трябва да се смени статуса на колата,
     * извършаваща поръчката, да стане "Свободен"... това може да се направи
     * и по друг начин, но върши работа за сега
    */
    public function deleteOrder($id, Request $request)
    {


        $order      = Orders::find($id);
        $vehicleID  = $order->vehicle_id;
        $vehicle    = Vehicles::find($vehicleID);
        $vehicle->vehicle_status_id = 1;
        $vehicle->save();
        $order->driver_id = NULL;
        $order->delete();

        $request->session()->flush('alert-success', 'Успешно изтрихте услуга!');

        return redirect()->route('show-orders');
    }


    /*
     * С помощта на функцията newOrderFromCustomer(), извличам всички заявки за поръчки
     * направени от клиент.
     * Проверявам дали статуса на тези поръчки не е "Приключена" или "Изпълнява се"
     * и връщам списък с поръчките от този клиент
     *
    */
    public function newOrderFromCustomer()
    {
        $closedId       =  OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_CLOSED)->first()->id;
        $processingId   =  OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_PROCESSING)->first()->id;
        $orders = Orders::where('order_status_id', '<>', $closedId)
                        -> where('order_status_id', '<>', $processingId)->get();
        return view('manager.pages.orders.new-orders')
                    ->with('orders', $orders);
    }


    /*
     * Справка за свободни МПС-та, към зададена дата
     * тука е голяма каша с тези join-ове, но не се сещам за друг начин.
     * Идеята е да взема всички МПС-та от таблиците 'vehicle_repair' и 'vehicle_reservation',
     * да проверя дали датата за която се прави справката е в диапазона от датите на двете таблици
     * и да върна всички други МПС-та
     *
     *
    */
    private function _getFreeVehiclesForDate($date){

        $dateSearch = Carbon::parse($date)->toDateString();
        $freeVehicles = Vehicles::query()
            ->leftJoin('vehicle_repair',  function($vehicleRepJoin) use ($dateSearch)
            {
                $vehicleRepJoin->on('vehicle_repair.vehicle_id', '=', 'vehicles.id');
                $vehicleRepJoin->on(DB::raw("date(vehicle_repair.dateInRepair)"),'<=',DB::raw("'$dateSearch'"));
                $vehicleRepJoin->on(DB::raw("date(vehicle_repair.dateOutRepair)"),'>=',DB::raw("'$dateSearch'"));

            })
            ->leftJoin('vehicle_reservation',  function($vehicleResJoin) use ($dateSearch)
            {
                $vehicleResJoin->on('vehicle_reservation.vehicle_id', '=', 'vehicles.id');
                $vehicleResJoin->on(DB::raw("date(vehicle_reservation.orderStartDate)"),'<=', DB::raw("'$dateSearch'"));
                $vehicleResJoin->on(DB::raw("date(vehicle_reservation.orderEndDate)"),'>=', DB::raw("'$dateSearch'"));

            })

            ->whereNull('vehicle_reservation.id')
            ->whereRaw(DB::raw("if(vehicle_repair.dateOutRepair is not null, date(vehicle_repair.dateOutRepair) < '{$dateSearch}', vehicle_repair.id is null)"))
            ->get(['vehicles.*']);
      //  dd($freeVehicles);
        return $freeVehicles;
    }


    /*
     * Извършване на самата справка
     * Проверявам дали полето за датата не е празно
     * извиквам функцията  _getFreeVehiclesForDate($date),
     * която връща списък със свободните МПС-та
     *
    */
    public function freeVehicles(Request $request)
    {

        $date= Carbon::now()->toDateString();
        if(isset($request->orderSearchDate) && $request->orderSearchDate != ''){
            $date = $request->orderSearchDate;
        }
        $freeVehicles = $this->_getFreeVehiclesForDate($date);

        return view('manager.pages.free-vehicles')
            ->with('freeVehicles', $freeVehicles)
            ->with('filterDate', $date);
    }


    /*
     * Справка за свободни шофьори, към търсена дата
     * по същия начин както във функцията _getFreeVehiclesForDate($date)
     *
    */
    private function _getFreeDriversForDate($date)
    {
        $dateSearch = Carbon::parse($date)->toDateString();
        $freeDrivers = User::query()
            ->join('roles', 'roles.id', '=', 'role_id')
            ->leftJoin('orders', 'driver_id', '=', 'users.id')
            ->leftJoin('vehicle_reservation',  function($vehicleResJoin) use ($dateSearch)
            {
                $vehicleResJoin->on('vehicle_reservation.driver_id', '=', 'users.id');
                $vehicleResJoin->on(DB::raw("date(vehicle_reservation.orderStartDate)"),'<=', DB::raw("'$dateSearch'"));
             $vehicleResJoin->on(DB::raw("date(vehicle_reservation.orderEndDate)"),'>=', DB::raw("'$dateSearch'"));

            })
//            ->Where('order_status_id', '<>',
//                $closedOrderId = OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_CLOSED)->first()->id3)
            ->where('roles.code', '=', Role::ROLE_DRIVER)
//            ->whereNull('users.id')
            ->whereRaw(DB::raw("if(vehicle_reservation.orderStartDate is not null, date(vehicle_reservation.orderEndDate) < '{$dateSearch}', vehicle_reservation.id is null)"))
            ->get(['users.*']);
        $dateSearch = Carbon::parse($date)->toDateString();

        return $freeDrivers;

    }

    public function freeDrivers(Request $request)
    {
        $date= Carbon::now()->toDateString();
        if(isset($request->orderSearchDate) && $request->orderSearchDate != ''){
            $date = $request->orderSearchDate;
        }

        $freeDrivers = $this->_getFreeDriversForDate($date);
        return view('manager.pages.free-drivers')
            ->with('freeDrivers', $freeDrivers)
            ->with('filterDate', $date);
    }

//    public function freeDrivers()
//    {
//        $drivers = User::whereHas('role', function ($query) {
//            $query->where('code', '=', Role::ROLE_DRIVER);
//        })->get();
//        return view('manager.pages.free-drivers')
//            ->with('drivers', $drivers);
//    }
//
//    public function storeOrderFromCustomer(Request $request)
//    {
//
//    }

}
