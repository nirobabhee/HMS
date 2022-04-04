<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40)->nullable();
            $table->string('email', 40)->unique();
            $table->string('username', 40)->unique();
            $table->string('password', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('mobile', 40)->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('gender')->default(1);
            $table->string('blood_group')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('age');
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
        Schema::dropIfExists('patients');
    }
}
