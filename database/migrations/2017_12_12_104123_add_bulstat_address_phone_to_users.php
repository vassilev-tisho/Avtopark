<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBulstatAddressPhoneToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table){
            $table->integer('bulstat')->nullable();
            $table->string('customerAddress')->nullable();
            $table->integer('customerPhone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table){
            $table->dropColumn('bulstat');
            $table->dropColumn('customerAddress');
            $table->dropColumn('customerPhone');
        });
    }
}
