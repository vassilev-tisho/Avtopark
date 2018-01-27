<?php


/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */


Route::get('/', function () {
    return view('');
});




Route::get('/home', 'HomeController@index')->name('home');
Route::get('/welcome', 'HomeController@welcome');
Route::get('/', 'HomeController@index')->name('dashboard');

Route::get('/profile/', 'ProfileController@profile');
Auth::routes();
Route::group(['middleware' => ['auth', 'roles'], 'prefix' => 'admin'], function ()
{
	Route::get('/', [
		'as'	 => 'admin',
		'uses'	 => 'AdminController@index',
		'roles'	 => ['admin'],
	]);

	Route::get('/users', [
		'as'	 => 'users',
		'uses'	 => 'AdminController@users',
		'roles'	 => ['admin'],
	]);

	Route::get('/create-user', [
		'as'	 => 'create-user',
		'uses'	 => 'AdminController@createUser',
		'roles'	 => ['admin'],
	]);

	Route::post('/create-user', [
		'as'	 => 'create-user',
		'uses'	 => 'AdminController@storeUser',
		'roles'	 => 'admin',
	]);

	Route::get('/delete-user/{id}', [
		'as'	 => 'delete-user',
		'uses'	 => 'AdminController@deleteUser',
		'roles'	 => ['admin'],
	]);

	Route::get('/edit-user/{id}', [
		'as'	 => 'edit-user',
		'uses'	 => 'AdminController@editUser',
		'roles'	 => 'admin',
	]);
	Route::post('/edit-user/{id}', [
		'as'	 => 'edit-user',
		'uses'	 => 'AdminController@saveUser',
		'roles'	 => 'admin',
	]);
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	Route::get('/show-services', [
		'as'	 => 'show-services',
		'uses'	 => 'AdminController@showService',
		'roles'	 => ['admin'],
	]);
	Route::get('/create-service', [
		'as'	 => 'create-service',
		'uses'	 => 'AdminController@createService',
		'roles'	 => ['admin'],
	]);
	Route::post('/create-service', [
		'as'	 => 'create-service',
		'uses'	 => 'AdminController@storeService',
		'roles'	 => ['admin'],
	]);
	Route::get('/edit-service/{id}', [
		'as'	 => 'edit-service',
		'uses'	 => 'AdminController@editService',
		'roles'	 => 'admin',
	]);

	Route::post('/edit-service/{id}', [
		'as'	 => 'edit-service',
		'uses'	 => 'AdminController@saveService',
		'roles'	 => 'admin',
	]);

	Route::get('/delete-service/{id}', [
		'as'	 => 'delete-service',
		'uses'	 => 'AdminController@deleteService',
		'roles'	 => ['admin'],
	]);
});
Route::group(['middleware' => ['auth', 'roles'], 'prefix' => 'manager'], function ()
{
	Route::get('/', [
		'as'	 => 'manager',
		'uses'	 => 'ManagerController@index',
		'roles'	 => ['manager', 'admin'],
	]);

	Route::get('/create-vehicle', [
		'as'	 => 'create-vehicle',
		'uses'	 => 'ManagerController@createVehicle',
		'roles'	 => ['admin', 'manager'],
	]);

	Route::post('/create-vehicle', [
		'as'	 => 'create-vehicle',
		'uses'	 => 'ManagerController@storeVehicle',
		'roles'	 => ['admin', 'manager'],
	]);

	Route::get('/show-vehicles', [
		'as'	 => 'show-vehicles',
		'uses'	 => 'ManagerController@showVehicles',
		'roles'	 => ['admin', 'manager']
	]);
	Route::get('/delete-vehicle/{id}', [
		'as'	 => 'delete-vehicle',
		'uses'	 => 'ManagerController@deleteVehicle',
		'roles'	 => ['admin', 'manager'],
	]);

	Route::get('/maps', [
		'as'	 => 'maps',
		'uses'	 => 'ManagerController@maps',
		'roles'	 => ['admin', 'manager']
	]);
	Route::get('/edit-vehicle/{id}', [
		'as'	 => 'edit-vehicle',
		'uses'	 => 'ManagerController@editVehicle',
		'roles'	 => ['admin', 'manager'],
	]);
	Route::post('/edit-vehicle/{id}', [
		'as'	 => 'edit-vehicle',
		'uses'	 => 'ManagerController@saveVehicle',
		'roles'	 => ['admin', 'manager'],
	]);

	Route::get('/show-orders',[
	    'as'    =>  'show-orders',
        'uses'  =>  'ManagerController@showOrders',
        'roles' =>  ['admin', 'manager'],
    ]);

	Route::get('/create-order', [
	    'as'    =>  'create-order',
        'uses'  =>  'ManagerController@createOrder',
        'roles' =>  ['admin', 'manager'],
    ]);

	Route::post('/create-order', [
	    'as'    =>  'create-order',
        'uses'  =>  'ManagerController@storeOrder',
        'roles' =>  ['admin', 'manager'],
    ]);

	Route::get('/edit-order/{id}', [
	    'as'    =>  'edit-order',
        'uses'  =>  'ManagerController@editOrder',
        'roles' =>  ['admin', 'manager'],
    ]);
	Route::post('/edit-order/{id}', [
	    'as'    =>  'edit-order',
        'uses'  =>  'ManagerController@saveOrder',
        'roles' =>  ['admin', 'manager'],
    ]);
    Route::get('/delete-order/{id}', [
        'as'	 => 'delete-order',
        'uses'	 => 'ManagerController@deleteOrder',
        'roles'	 => ['admin', 'manager'],
    ]);

    Route::get('/vehicle-profile/{id}', [
        'as'	 => 'vehicle-profile',
        'uses'	 => 'ManagerController@vehicleProfile',
        'roles'	 => ['admin', 'manager'],
    ]);

    Route::get('/vehicle-repair-profile/{id}', [
        'as'	 => 'vehicle-repair-profile',
        'uses'	 => 'ManagerController@vehicleRepairProfile',
        'roles'	 => ['admin', 'manager'],
    ]);

    Route::get('/new-orders', [
        'as'     =>  'new-orders',
        'uses'   =>  'ManagerController@newOrderFromCustomer',
        'roles'	 => ['admin', 'manager'],
    ]);

    Route::post('/create-customer-order/{id}', [
        'as'     =>  'create-customer-order',
        'uses'   =>  'ManagerController@storeOrderFromCustomer',
        'roles'	 => ['admin', 'manager'],
    ]);

    Route::get('/free-vehicles', [
        'as'     =>  'free-vehicles',
        'uses'   =>  'ManagerController@freeVehicles',
        'roles'	 => ['admin', 'manager'],
    ]);

    Route::post('/free-vehicles', [
        'as'     =>  'free-vehicles',
        'uses'   =>  'ManagerController@getFreeVehicles',
        'roles'	 => ['admin', 'manager'],
    ]);

    Route::get('/free-drivers', [
        'as'     =>  'free-drivers',
        'uses'   =>  'ManagerController@freeDrivers',
        'roles'	 => ['admin', 'manager'],
    ]);
});

Route::group(['middleware' => ['auth', 'roles'], 'prefix' => 'customer'], function ()
{
	Route::get('/', [
		'as'	 => 'customer',
		'uses'	 => 'CustomerController@index',
		'roles'	 => ['customer'],
	]);

	Route::get('/create-customer-order', [
	    'as'    =>  'create-customer-order',
        'uses'  =>  'CustomerController@createOrder',
        'roles' =>  ['admin', 'customer']
    ]);

    Route::post('/create-customer-order', [
        'as'    =>  'create-customer-order',
        'uses'  =>  'CustomerController@storeOrder',
        'roles' =>  ['admin', 'customer']
    ]);

    Route::get('/customer-orders', [
        'as'    =>  'customer-orders',
        'uses'  =>  'CustomerController@showCustomerOrders',
        'roles' =>  ['admin', 'customer']
    ]);

    Route::post('/calculate-order', [
        'as'    =>  'calculate-order',
        'uses'  =>  'CustomerController@calculateOrder',
        'roles' =>  ['admin', 'customer']
    ]);
});

Route::group(['middleware' => ['auth', 'roles'], 'prefix' => 'driver'], function ()
{
	Route::get('/', [
		'as'	 => 'driver',
		'uses'	 => 'DriverController@index',
		'roles'	 => ['driver'],
	]);
    Route::post('/start-order', [
        'as'	 => 'startOrder',
        'uses'	 => 'DriverController@startOrder',
        'roles'	 => ['driver'],
    ]);
    Route::post('/end-order', [
        'as'	 => 'endOrder',
        'uses'	 => 'DriverController@endOrder',
        'roles'	 => ['driver'],
    ]);
});
