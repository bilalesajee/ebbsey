<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    function ratedBy(){
       return $this->hasOne(User::class,'id','rated_by');
    }
    
    function ratedTo(){
       return $this->hasOne(User::class,'id','user_id');
    }
}
