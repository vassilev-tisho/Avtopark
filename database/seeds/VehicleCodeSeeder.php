<?php

use Illuminate\Database\Seeder;
use App\Vehicle_types;
use Illuminate\Support\Facades\DB;
class VehicleCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('vehicle_status')->delete();

//        DB::table('vehicle_types')->insert([
//            'id'    =>  1,
//            'type'  => 'Car',
//            'code'  => 'Кола',
//
//        ]);
//
//        DB::table('vehicle_types')->insert([
//            'id'    =>  2,
//            'type'  => 'Bus',
//            'code'  => 'Бус',
//        ]);
//
//
//        DB::table('vehicle_types')->insert([
//            'id'    =>  3,
//            'type'  => 'Truck',
//            'code'  => 'Камион',
//
//        ]);

    }
}
