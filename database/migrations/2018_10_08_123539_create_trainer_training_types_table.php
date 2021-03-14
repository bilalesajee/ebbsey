<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainerTrainingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_training_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trainer_id')->unsigned();
            $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('training_type_id')->unsigned();
            $table->foreign('training_type_id')->references('id')->on('training_types')->onDelete('cascade');
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
        Schema::dropIfExists('trainer_training_types');
    }
}
