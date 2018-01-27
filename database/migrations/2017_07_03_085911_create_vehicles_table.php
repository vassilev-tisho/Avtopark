<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand');
            $table->string('fuelType');
            $table->string('regNumber');
            $table->integer('vehicle_types_id');
            $table->integer('vehicle_status_id');
            $table->date('insurance');
            $table->date('technicalReview');
            $table->float('fuelConsumption');
            $table->float('fuelConsumptionCharged');
            $table->integer('chargeWeight');
            $table->integer('mileage');  //пробег
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
        Schema::dropIfExists('vehicles');
        Schema::dropColumn('fuelConsumptionCharged');
    }
}
