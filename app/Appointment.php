<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    function appointmentClient(){
       return $this->hasOne(User::class,'id','client_id');
    }
    function appointmentTrainer(){
       return $this->hasOne(User::class,'id','trainer_id');
    }
    function classAppointment(){
       return $this->hasOne(Classes::class,'id','class_id');
    }
    function refferAppointment(){
       return $this->hasOne(RefferTrainee::class,'appointment_id','id');
    } 
    function getReferredBy(){
       return $this->hasOne(User::class,'id','owner_id');
    } 
}
