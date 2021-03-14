<?php

namespace App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    function classtTrainer(){
       return $this->hasOne(User::class,'id','trainer_id');
    }
    
    function classtType(){
       return $this->hasOne(ClassType::class,'id','class_type_id');
    }
    
    function classTimetable(){
        return $this->hasMany(ClassTimetable::class,'class_id','id');
    }
    
    function getImage(){
        return $this->hasOne(Images::class,'id','image_id');
    }
    function classImages(){
        return $this->hasMany(ClassImage::class,'class_id','id');
    }
    
    function countSpot(){
        return $this->hasMany(Appointment::class,'class_id','id');
    }
    function getBooking(){
        return $this->hasOne(Appointment::class,'class_id','id')->where('status','accepted')->where('client_id',Auth::id());
    }
    
     
}
