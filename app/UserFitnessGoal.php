<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFitnessGoal extends Model
{
    function goal() {
        return $this->hasOne(FitnessGoal::class, 'id', 'fitness_goal_id');
    }
}
