<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	/*
		    |--------------------------------------------------------------------------
		    | Login Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller handles authenticating users for the application and
		    | redirecting them to your home screen. The controller uses a trait
		    | to conveniently provide its functionality to your applications.
		    |
	*/

	use AuthenticatesUsers;
	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	protected function authenticated(Request $request, $user)
	{
	    //проверка дали потребителят е администратор
        switch (Auth::user()->role->code)
        {
            case \App\Role::ROLE_ADMINISTRATOR:
                return redirect()->route('admin');
            case \App\Role::ROLE_MANAGER:
                return redirect()->route('manager');
            case \App\Role::ROLE_CUSTOMER:
                return redirect()->route('customer');
            case \App\Role::ROLE_DRIVER:
                return redirect()->route('driver');
            default:
                return redirect()->route('logout');
        }

	}
}
