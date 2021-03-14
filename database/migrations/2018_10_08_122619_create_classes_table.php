<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class_name');
            $table->string('class_type')->nullable();
            $table->bigInteger('class_type_id')->unsigned()->nullable();
            $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('cascade');
            $table->string('difficulty_level')->nullable();
            $table->string('duration')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('calories')->nullable();
            $table->string('location')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('spot')->nullable();
            $table->string('participants')->nullable();
            $table->longText('description')->nullable();
            $table->string('image_id')->nullable();
            $table->boolean('is_featured_by_admin')->default(0); 
            $table->Integer('is_report_sent')->nullable()->default('0');
            $table->enum('status', ['open', 'completed'])->default('open');
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
        Schema::dropIfExists('classes');
    }
}
