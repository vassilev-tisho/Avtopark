<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderEditRequest extends FormRequest
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

            'vehicle'                    =>  'required',
            'driver'                     =>  'required',
            'orderDate'                  =>  'required|date',
        ];
    }

    public function messages()
    {
        return [
            'vehicle.required'              =>  'Полето "Превозно средство" е задължително!',
            'driver.required'               =>  'Полето "Шофьор" е задължително!',
            'orderDate.date' => 'Посочената от вас дата не е коректна! Моля въведете коректна дата!',

        ];
    }
}
