<?php

use Illuminate\Database\Seeder;
use App\OrderStatus;
class NewOrderStatusFeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'id'	 => 4,
            'type'   => 'New',
            'code'	 => 'Нова',
        ]);
    }
}
