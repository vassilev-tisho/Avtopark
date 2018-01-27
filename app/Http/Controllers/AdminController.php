<?php

namespace App\Http\Controllers;

use App\User;
use App\Services;
use App\Http\Requests\ShareFormRequest;
use App\Http\Requests\StoreService;

class AdminController extends Controller
{

    //начална страница
	public function index()
	{
		return view('admin.pages.index');
	}

	//Връща списък с всички потребители
	public function users()
	{
		$users = User::all();
		return view('admin.pages.users')->with('users', $users);
	}

	//Форма за добавяне на потребител
	public function createUser()
	{
		$roles = \App\Role::all();
		return view('admin.pages.create-user')
				->with('roles', $roles);
	}

	//Запис на потребител
	public function storeUser(ShareFormRequest $request)
	{

		$user = new User();
		$user->store($request);

		$request->session()->flash('alert-success', 'Успешно добавихте потребител!');
		return redirect()->route('users');
	}

	//Изтриване на потребител
	public function deleteUser($id, \Illuminate\Http\Request $request)
	{
		User::find($id)->delete();

		$request->session()->flash('alert-success', 'Успешно изтрихте потребител!');
		return redirect()->route('users');
	}

	// Форма за редактиране на съществуващ потребител
	public function editUser($id)
	{
		$user	 = User::find($id);
		$roles	 = \App\Role::all();
		return view('admin.pages.edit-user')
				->with('user', $user)
				->with('roles', $roles);
	}

	// Запазване на промените за потребител, след редактиране
	public function saveUser($id, ShareFormRequest $request)
	{
		$user = User::find($id);
		foreach ($request->all() as $k => $v)
		{
			if (in_array($k, $user->getFillable()))
			{
				$user->$k = $v;
			}
		}
        if($user->role->code != 'DRIVER' ){
            $user->driveLicenseCategory =  '';
            $user->driveLicenseExpired =  null;
        }
        $user->save();

		$roles = \App\Role::all();

		$request->session()->flash('alert-success', 'Успешно редактирахте потребител!');
		return view('admin.pages.edit-user')
				->with('user', $user)
				->with('roles', $roles);
	}

	// Списък с всички услуги
    public function showService()
	{
		return view('admin.pages.services')->with('services', Services::all());
	}

	//Форма за добавяне на нова услуга
	public function createService()
	{
		return view('admin.pages.create-service');
	}

	// Запис на услуга
	public function storeService(StoreService $request)
	{
		$service = new Services();
		$service->create($request);

		$request->session()->flash('alert-success', 'Успешно добавихте Услуга!');
		return redirect()->route('show-services');
	}

	//Редакция на съществуваща услуга
	public function editService($id)
	{
		$service = Services::find($id);
		return view('admin.pages.edit-service')
				->with('service', $service);
	}

	//Запис на услуга след редакция
	public function saveService($id, StoreService $request)
	{
		$service = Services::find($id);
		foreach ($request->all() as $k => $v)
		{
			if (isset($service->$k))
			{
				$service->$k = $v;
			}
		}
		$service->save();


		$request->session()->flash('alert-success', 'Успешно редактирахте услуга!');
		return view('admin.pages.edit-service')
				->with('service', $service);
	}

	//Изтриване на услуга
	public function deleteService($id, \Illuminate\Http\Request $request)
	{
		Services::find($id)->delete();

		$request->session()->flash('alert-success', 'Успешно изтрихте услуга!');
		return redirect()->route('show-services');
	}

}
