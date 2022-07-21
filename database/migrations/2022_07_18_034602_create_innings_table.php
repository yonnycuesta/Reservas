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
        Schema::create('innings', function (Blueprint $table) {
            $table->engine = 'innoDB';
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('Employee id');
            $table->string('customer_name')->comment('Customer Name');
            $table->string('customer_phone')->comment('Customer Phone');
            $table->string('customer_email')->nullable()->comment('Customer Email');
            $table->string('service')->comment('Services');
            $table->string('part_day')->comment('Part of the day of the inning');
            $table->date('inning_date')->comment('Date of the inning');
            $table->time('inning_hour')->comment('Hour of the inning');
            $table->text('description')->nullable()->comment('Description of the inning');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'solved'])->default('confirmed')->comment('Status of the inning');
            $table->text('file_attachment')->nullable()->comment('File add of the inning');

            $table->timestamps();

            // Relationship
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('innings');
    }
};
