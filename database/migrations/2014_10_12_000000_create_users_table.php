<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('original_image')->nullable();
            $table->string('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('ssn')->nullable();
            $table->string('fb_url')->nullable();
            $table->string('insta_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->string('rating')->nullable();
            $table->string('passes_count')->nullable();
            $table->string('total_cash')->nullable();
            $table->string('distance')->nullable();
            $table->enum('user_type', ['user', 'trainer']);
            $table->boolean('is_featured_by_admin')->default(0);
            $table->string('license_expire_date')->nullable();
            $table->string('last_login')->nullable();
            $table->string('last_logout')->nullable();
            $table->rememberToken();
            $table->string('referral_code')->nullable();
            $table->string('activation_code')->nullable();
            $table->string('reset_password_code')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_image_approved_by_admin')->default(0);
            $table->boolean('is_approved_by_admin')->default(0);
            $table->string('block_time');
            $table->string('account_status')->default(0)->nullable();
            $table->string('stripe_payout_account_id')->nullable();
            $table->string('stripe_payout_account_public_key')->nullable();
            $table->string('stripe_payout_account_secret_key')->nullable();
            $table->longText('stripe_payout_account_info')->nullable();
            $table->boolean('is_bank_account_verified')->default(0);
            $table->string('stripe_express_dashboard_url')->nullable();
            $table->string('google_access_token')->nullable();
            $table->string('google_refresh_token')->nullable();
            $table->string('google_token_type')->nullable();
            $table->bigInteger('google_token_expires_in')->nullable();
            $table->bigInteger('google_token_created')->nullable();
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
        Schema::dropIfExists('users');
    }
}
