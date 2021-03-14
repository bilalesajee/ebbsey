<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessCardOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_card_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ordered_by')->unsigned();
            $table->enum('type',['simple','custom','both']);
            $table->foreign('ordered_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('title')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            
            $table->string('stripe_id')->nullable();
            $table->string('address')->nullable();
            
            $table->string('admin_location')->nullable();
            $table->string('client_location')->nullable();
            
            $table->string('pay_later')->nullable();
            $table->string('order_time')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('url')->nullable();
            $table->string('number_of_cards')->nullable();
            $table->string('price')->nullable();
            $table->string('shot_date')->nullable();
            $table->boolean('is_order_completed')->default(0);
            $table->boolean('is_payout')->default(0);
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
        Schema::dropIfExists('business_card_orders');
    }
}
