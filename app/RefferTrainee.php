<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefferTrainee extends Model
{
      function getUser(){
       return $this->hasOne(User::class,'id','trainee_id');
    }
}
