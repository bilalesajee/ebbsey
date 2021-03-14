<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pass_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('price')->nullable();
            $table->string('bronze_passes')->nullable();
            $table->string('bronze_price')->nullable();
            $table->string('silver_passes')->nullable();
            $table->string('silver_price')->nullable();
            $table->string('gold_passes')->nullable();
            $table->string('gold_price')->nullable();
            $table->string('base_rate')->nullable();
            $table->string('lowest_base_rate')->nullable();
            $table->string('highest_base_rate')->nullable();
            $table->string('trainer_earning_base_rate')->nullable();
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
        Schema::dropIfExists('pass_prices');
    }
}
