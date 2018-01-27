<?php

use Illuminate\Database\Seeder;

use App\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'id'    => 1,
            'type'  => 'Free',
            'code'  => 'Свободен',
        ]);

        Status::create([
            'id'    => 2,
            'type'  => 'OnRoad',
            'code'  => 'На път',

        ]);

        Status::create([
            'id'    => 3,
            'type'  => 'OnRepair',
            'code'  => 'В ремонт'
        ]);

        Status::create([
            'id'    => 4,
            'type'  => 'Reserved',
            'code'  => 'Резервиран'
        ]);
    }
}
