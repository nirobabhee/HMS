<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->string('title',100)->nullable();
            $table->tinyInteger('read_status')->default(0);
            $table->text('click_url')->nullable();
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
        Schema::dropIfExists('doctor_notifications');
    }
}
