<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = ['referral_code', 'passes_count', 'user_id', 'trainer_id'];
}
