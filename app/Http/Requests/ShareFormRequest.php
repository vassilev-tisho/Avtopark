<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareFormRequest extends FormRequest
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
			'firstName'	 => 'required',
			'lastName'	 => 'required',
			'email'		 => 'required|email|unique:users,email,' . $this->get('usrd'),
			'password'	 => 'min:5',
			'egn'		 => 'numeric|digits:10',
			'role_id'	 => 'required'
		];
	}

	public function messages()
	{
		return [
			'firstName.required' => 'Полето "Име" е задължително!',
			'lastName.required'	 => 'Полето "Фамилия" е задължително!',
			'email.required'	 => 'Полето "E-mail" е задължително!',
			'email.email'		 => 'Това не е валиден email адрес!',
			'email.unique'		 => 'В базата съществува запис с този email адрес. Моля изберете друг!',
			'egn.numeric'		 => 'ЕГН-то трябва да е число!',
			'egn.digits'		 => 'ЕГН-то трябва да съдържа точно 10 символа!',
			'password.min'		 => 'Паролата трябва да съдържа поне 6 символа!',
			'role_id.required'	 => 'Полето "Роля на потребител" е задължително!'
		];
	}

}
