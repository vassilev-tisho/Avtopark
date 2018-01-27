<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_reservation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_id');
            $table->integer('driver_id');
            $table->integer('customer_id');
            $table->integer('order_id');
            $table->dateTime('orderStartDate');
            $table->dateTime('orderEndDate');
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
        Schema::dropIfExists('vehicle_reservation');
    }
}
