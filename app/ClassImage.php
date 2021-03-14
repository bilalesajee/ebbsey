<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassImage extends Model
{
    function classFunction(){
       return $this->hasOne(Classes::class,'id','class_id');
    }
    
    function imageFunction(){
       return $this->hasOne(Images::class,'id','image_id');
    }
}
