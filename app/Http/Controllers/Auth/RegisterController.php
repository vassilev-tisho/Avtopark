<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RestrationFormRequest;
use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName'                    => 'required|max:255',
            'lastName'                     => 'required|max:255',
            'email'                        => 'required|email|max:255|unique:users',
            'password'                     => 'required|min:6|confirmed',
            'password_confirmation'        => 'required|min:6',
            'client_type'                  => 'required|max:255',
        ],
            [
                'firstName.required'    => 'Моля въведете коректно име!',
            ]);
    }
//    protected function create(array $data)
//    {
//        $role    = Role::where('code', 'CUSTOMER')->first();
//        $user = User::create([
//            'firstName'       => $data['firstName'],
//            'lastName'        => $data['lastName'],
//            'email'           => $data['email'],
//            'password'        => bcrypt($data['password']),
//            'role_id'         => $role->id,
//            'bulstat'         => $data['bulstat'],
//            'customerAddress' => $data['customerAddress'],
//            'customerPhone'   => $data['customerPhone'],
//            'egn'             => $data['egn'],
////            'drive_license' => $data['drive_license'],
////            'role_id' => $data['role_id']
//        ]);
//
//        return $user;
//    }

    public function create(Request $request)
    {
        $this->validate($request, User::$create_validation_rules);
        $this->role    = Role::where('code', 'CUSTOMER')->first();
        $this->firstName			 = $request->firstName;
        $this->lastName				 = $request->lastName;
        $this->email				 = $request->email;
        $this->password				 = bcrypt($request->password);
        $this->egn					 = $request->egn;

        $this->bulstat               = $request->bulstat;
        $this->customerAddress       = $request->customerAddress;
        $this->customerPhone         = $request->customerPhone;
        $this->save();
    }



}
