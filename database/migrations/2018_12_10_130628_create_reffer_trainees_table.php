<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefferTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reffer_trainees', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('appointment_id')->unsigned();
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            
            $table->bigInteger('trainee_id')->unsigned();
            $table->foreign('trainee_id')->references('id')->on('users')->onDelete('cascade');
            
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
        Schema::dropIfExists('reffer_trainees');
    }
}
