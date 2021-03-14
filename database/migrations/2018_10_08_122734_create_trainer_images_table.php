<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainerImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trainer_id')->unsigned();
            $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade');            
            $table->string('path')->nullable();
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
        Schema::dropIfExists('trainer_images');
    }
}
