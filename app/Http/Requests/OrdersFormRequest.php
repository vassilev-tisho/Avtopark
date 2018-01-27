<?php

namespace App\Http\Requests;

use App\Orders;
use App\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class OrdersFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
            return [

                'services'                   =>  'required',
                'vehicle'                    =>  'required',
                'driver'                     =>  'required',
                //      'manager_id'                 =>  'required',
                'addressSending'             =>  'required',
                'addressReceiver'            =>  'required',
                'kilometres'                 =>  'required',
                'price'                      =>  'required',
                'customer_id'                =>  'required',
                'time'                       =>  'required',
                'orderDate'                  =>  'required|date',
                //   'order_status_id'            =>  'required',
            ];

//        return [
//
//            'services'                   =>  'required',
//            'vehicle'                    =>  'required',
//            'driver'                     =>  'required',
//      //      'manager_id'                 =>  'required',
//            'addressSending'             =>  'required',
//            'addressReceiver'            =>  'required',
//            'kilometres'                 =>  'required',
//            'price'                      =>  'required',
//            'customer_id'                =>  'required',
//            'time'                       =>  'required',
//            'orderDate'                  =>  'required|date',
//         //   'order_status_id'            =>  'required',
//        ];
    }

    public function messages()
    {
        return [

                'services.required' => 'Полето "Вид на услугата" е задължително!',
                'vehicle.required' => 'Полето "Превозно средство" е задължително!',
                'driver.required' => 'Полето "Шофьор" е задължително!',
                //   'manager_id.required'        =>  'Полето "Мениджър", е задължително!',
                'addressSending.required' => 'Полето "Адрес на изпращане" е задължително!',
                'addressReceiver.required' => 'Полето "Адрес на получаване" е задължително!',
                'kilometres.required' => 'Полето "Разстояние" е задължително!',
                'price.required' => 'Полето "Цена" е задължително!',
                'customer_id.required' => 'Полето "Клиент" е задължително!',
                'time.required' => 'Полето "Време за пристигане" е задължително!',
                'orderDate.required' => 'Полето "Дата на поръчката" е задължително!',
                'orderDate.date' => 'Посочената от вас дата не е коректна! Моля въведете коректна дата!',

                // 'order_status_id.required'   =>  'Полето "Статус на поръчката", е задължително!',
            ];

    }
}
