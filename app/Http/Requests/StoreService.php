<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreService extends FormRequest
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
			'name'			 => 'required|unique:services,name,' . $this->get('srvd'),
			'description'	 => 'required',
			'priceLoaded'	 => 'required',
			'priceUnLoaded'	 => 'required',
			'minWeight'		 => 'required',
			'maxWeight'		 => 'required',
		];
	}

	public function messages()
	{
		return [
			'name.required'			 => 'Полето "Име" е задължително!',
			'name.unique'			 => 'В базата съществува услуга с това име!',
			'description.required'	 => 'Полето "Описание" е задължително!',
			'priceLoaded.unique'	 => 'Полето "Цена натоварен" е задължително!',
			'priceUnLoaded.required' => 'Полето "Цена празен" е задължително!',
			'minWeight.required'	 => 'Полето "Минимален товар" е задължително!',
			'maxWeight.required'	 => 'Полето "Максимален товар" е задължително!',
		];
	}

}
