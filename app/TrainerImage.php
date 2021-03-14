<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerImage extends Model
{
    function getImage(){
       return $this->hasOne(Images::class,'id','image_id');
    }
}
