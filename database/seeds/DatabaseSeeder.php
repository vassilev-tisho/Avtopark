<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//
        $this->call(VehicleCodeSeeder::class);
		$this->call(VehicleTypeSeeder::class);
		$this->call(StatusTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(OrderStatusTableSeeder::class);
		$this->call(NewOrderStatusFeeder::class);
	}

}
