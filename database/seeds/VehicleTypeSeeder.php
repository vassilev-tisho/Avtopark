<?php

use Illuminate\Database\Seeder;

use App\Vehicle_types;
class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle_types::create([
            'id'    =>  1,
            'type'  => 'Car',
            'code'  => 'Кола',
        ]);

        Vehicle_types::create([
            'id'    =>  2,
            'type'  => 'Bus',
            'code'  => 'Бус',
        ]);

        Vehicle_types::create([
            'id'    =>  3,
            'type'  => 'Truck',
            'code'  => 'Камион',
        ]);
    }
}
