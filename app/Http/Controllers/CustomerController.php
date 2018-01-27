<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Http\Requests\CustomerCreateOrder;
use App\OrderStatus;
use Illuminate\Http\Request;
use Auth;

class CustomerController extends Controller
{

	public function index()
	{
		return view('customer.pages.index');
	}

	/*
	 * Форма за подаване на заявка за извършване на услуга
	*/
	public function createOrder()
    {
        $services = \App\Services::get();
        return view('customer.pages.create-order')
                    ->with('services', $services);
    }

    /*
     * Записване на заявката
    */
    public function storeOrder(CustomerCreateOrder $request){
	    $order = new Orders();
	    $order->createForCustomer($request);
//        $orderPrice     = $order->calculatePriceOfOrder($order->id);
//        $order->price   = $orderPrice;
       // $order->save();
      //  dd($order->orderStatus->)

	    return redirect()->route('customer-orders');
    }

    /*
     * Показване на всички поръчки, направени от клиента
    */
    public function showCustomerOrders()
    {
        $customer = Auth::user();
        //$closedId = OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_CLOSED);
        $orders   = Orders::where('customer_id', '=', $customer->id)->get();
        return view('customer.pages.customer-orders')
                    ->with('orders', $orders);

    }
}
