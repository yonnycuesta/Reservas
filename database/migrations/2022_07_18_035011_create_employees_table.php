<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->engine = 'innoDB';
            $table->id();
            $table->string('name')->comment('Name of the employee');
            $table->string('email')->nullable()->unique()->comment('Email of the employee');
            $table->string('phone')->unique()->comment('Phone of the employee');
            $table->string('address')->nullable()->comment('Address of the employee');
            $table->text('profile')->comment('Profile of the employee');
            $table->timestamps();

            // Relationship
            //$table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
