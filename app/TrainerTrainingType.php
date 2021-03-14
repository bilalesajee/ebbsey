<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerTrainingType extends Model
{
    function trainingTypes(){
        return $this->belongsTo(TrainingType::class,'training_type_id','id');
    }
}
