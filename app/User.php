<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

	use Notifiable;

	protected $primaryKey = 'id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstName', 'lastName', 'email', 'password', 'egn', 'driveLicenseCategory', 'driveLicenseExpired', 'role_id',
        'bulstat', 'customerAddress', 'customerPhone'
	];
	protected $haveRole;

	//връзка 1->1 с таблица roles
	public function role()
	{
		return $this->hasOne('App\Role', 'id', 'role_id');
	}

	public function orders()
    {
        return $this->hasMany('App\Orders', 'driver_id', 'id');
    }

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden	 = [
		'password', 'remember_token',
	];
	protected $dates	 = [
		'driveLicenseExpired',
	];

	public function store(\Illuminate\Http\Request $request)
	{
		$this->firstName			 = $request->firstName;
		$this->lastName				 = $request->lastName;
		$this->email				 = $request->email;
		$this->password				 = bcrypt($request->password);
		$this->egn					 = $request->egn;
		$this->driveLicenseCategory	 = $request->category;
		$this->driveLicenseExpired	 = $request->expired;
		$this->role_id				 = $request->role_id;
		$this->bulstat               = $request->bulstat;
		$this->customerAddress       = $request->customerAddress;
		$this->customerPhone         = $request->customerPhone;
		$this->save();
	}

	public static $create_validation_rules = [
        'firstName'                    => 'required|max:255',
        'lastName'                     => 'required|max:255',
        'email'                        => 'required|email|max:255|unique:users',
        'password'                     => 'required|min:6|confirmed',
        'password_confirmation'        => 'required|min:6',
        'client_type'                  => 'required|max:255',
    ];
	public function hasRole($roles)
	{
		$this->haveRole = $this->getUserRole();
		// Check if the user is a root account
		if ($this->haveRole->code == 'ADMIN')
		{
			return true;
		}
		if (is_array($roles))
		{
			foreach ($roles as $need_role)
			{
				if ($this->checkIfUserHasRole($need_role))
				{
					return true;
				}
			}
		}
		else
		{
			return $this->checkIfUserHasRole($roles);
		}
		return false;
	}

	private function getUserRole()
	{
		return $this->role()->getResults();
	}

	private function checkIfUserHasRole($need_role)
	{
		return (strtolower($need_role) == strtolower($this->haveRole->code)) ? true : false;
	}

    public function getFullNameAttribute()
    {
        return ucfirst($this->firstName) . ' ' . ucfirst($this->lastName);
    }

    public function getDriverNewOrders()
    {
	    $newOrderId = OrderStatus::where('type', '=',  OrderStatus::ORDER_STATUS_PROCESSING)->first()->id;
        return Orders::where('driver_id', '=', $this->id)
            ->where('order_status_id', '=', $newOrderId)
            ->orderBy('created_at', 'desc')
            ->limit(5);
    }

    public function getCustomerNewOrders()
    {
        $newOrderId = OrderStatus::where('type', '=', OrderStatus::ORDER_STATUS_NEW)->first()->id;
        return Orders::whereNull('manager_id')
                ->where('order_status_id', '=', $newOrderId)
                ->orderBy('created_at', 'desc')
                ->limit(5);
    }
}
