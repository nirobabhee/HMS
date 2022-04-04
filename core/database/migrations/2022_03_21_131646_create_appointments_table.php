<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('doctor_id')->unsigned();
            $table->integer('slot_id')->unsigned();
            $table->date('date');
            $table->integer('serial_no');
            $table->text('disease_details');
            $table->tinyInteger('live_consultant')->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('appointments');
    }
}
