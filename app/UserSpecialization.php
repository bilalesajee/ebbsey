<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSpecialization extends Model
{
    function getSpecialization(){
       return $this->hasOne(Specialization::class,'id','specialization_id');
    }
    function getUser(){
       return $this->hasOne(User::class,'id','user_id');
    }
}
