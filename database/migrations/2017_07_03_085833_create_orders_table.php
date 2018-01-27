<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('services_id');
            $table->integer('vehicle_id');
            $table->integer('driver_id');
            $table->integer('manager_id');
            $table->text('addressSending');
            $table->text('addressReceiver');
            $table->decimal('price');
            $table->float('kilometres'); // После да се провери типа
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
