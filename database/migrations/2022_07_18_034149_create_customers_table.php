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
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'innoDB';
            $table->id();
            $table->string('name')->comment('Name of the customer');
            $table->string('email')->nullable()->unique()->comment('Email of the customer');
            $table->string('phone')->unique()->comment('Phone of the customer');
            $table->string('address')->nullable()->comment('Address of the customer');
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
        Schema::dropIfExists('customers');
    }
};
