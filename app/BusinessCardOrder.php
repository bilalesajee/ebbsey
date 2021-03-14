<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessCardOrder extends Model
{
    function cardsOrderBy(){
       return $this->hasOne(User::class,'id','ordered_by');
    }
}
