<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserQualification extends Model
{
    function getQualification(){
       return $this->hasOne(Qualification::class,'id','qualification_id');
    }
}
