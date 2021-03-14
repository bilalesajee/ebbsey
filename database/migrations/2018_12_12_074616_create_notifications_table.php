<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            
             $table->bigInteger('from_user')->unsigned();
            $table->foreign('from_user')->references('id')->on('users')->onDelete('cascade');
            
            $table->bigInteger('to_user')->unsigned();
            $table->foreign('to_user')->references('id')->on('users')->onDelete('cascade');

            $table->string('type', 100)->nullable();
            $table->integer('type_id')->nullable(); 
            $table->integer('is_read')->nullable(); 
            
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
        Schema::dropIfExists('notifications');
    }
}
