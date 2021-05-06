<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('registrationNumber')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('fuleType')->nullable();
            $table->string('motStatus')->nullable();
            $table->string('color')->nullable();
            $table->date('motExpiryDate')->nullable();
            $table->date('yearOfManufacture');
            $table->foreignId('customer_id')->contrained();
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
    }
}
