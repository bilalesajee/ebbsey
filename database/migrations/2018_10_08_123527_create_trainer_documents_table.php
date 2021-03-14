<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trainer_id')->unsigned();
            $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('file');
            $table->enum('document_type', ['cv', 'certification'])->nullable();
            $table->bigInteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('training_types')->onDelete('cascade');
            $table->boolean('is_approved_by_admin')->default(0);
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
        Schema::dropIfExists('trainer_documents');
    }
}
