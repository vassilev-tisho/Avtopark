<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleRepairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_repair', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_id');
            $table->string('serviceName');
            $table->date('dateInRepair');
            $table->date('dateOutRepair')->nullable();
            $table->string('repairType');
            $table->decimal('price');
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
        Schema::dropIfExists('vehicle_repair');
    }
}
