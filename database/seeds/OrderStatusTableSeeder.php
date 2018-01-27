<?php

use Illuminate\Database\Seeder;
use App\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'id'	 => 1,
            'type'   => 'Processing',
            'code'	 => 'Обработва се',
        ]);

        OrderStatus::create([
            'id'	 => 2,
            'type'   => 'Sent',
            'code'	 => 'Изпратена',
        ]);

        OrderStatus::create([
            'id'	 => 3,
            'type'   => 'Closed',
            'code'	 => 'Приключена',
        ]);

    }
}
