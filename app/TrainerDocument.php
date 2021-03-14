<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerDocument extends Model
{
    function certificateType(){
       return $this->hasOne(TrainingType::class,'id','type_id');
    }
    
    function getUser(){
       return $this->hasOne(User::class,'id','trainer_id');
    }
}
