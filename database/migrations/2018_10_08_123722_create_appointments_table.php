<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('trainer_id')->unsigned()->nullable();
            $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('class_id')->unsigned()->nullable();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->enum('type', ['session', 'class'])->nullable();
            $table->string('number_of_passes')->nullable();
            $table->string('date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'canceled', 'referred', 'completed', 'expired'])->nullable();
            $table->string('cancel_by')->nullable();
            $table->string('trainer_location')->nullable();
            $table->string('trainer_lat')->nullable();
            $table->string('trainer_lng')->nullable();
            $table->string('client_location')->nullable();
            $table->string('client_lat')->nullable();
            $table->string('client_lng')->nullable();
            $table->string('distance')->nullable();
            $table->boolean('is_referral_enabled')->default('0');
            $table->string('travelling_time')->nullable();
            $table->string('total_time')->nullable();
            $table->boolean('delete_by_client')->default('0');
            $table->boolean('delete_by_tranee')->default('0');
            $table->string('amount_to_transfer')->nullable();
            $table->boolean('is_seen_by_trainer')->default('0');
            $table->boolean('is_seen_by_client')->default('0');
            $table->boolean('is_reminder_sent')->default('0');
            $table->string('referred_by')->nullable();
            $table->boolean('is_referred_after_allowed_time')->default('0');
            $table->boolean('is_refunded')->default('0');
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
