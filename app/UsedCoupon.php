<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsedCoupon extends Model
{
    protected $fillable = ['user_id', 'coupon_id'];
}
