<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function trainerTrainingTypes() {
        return $this->hasMany(TrainerTrainingType::class, 'trainer_id', 'id');
    }

    function trainerImage() {
        return $this->hasMany(TrainerImage::class, 'trainer_id', 'id');
    }

    function trainerRating() {
        return $this->hasMany(Rating::class, 'user_id', 'id');
    }
    function trainerDocuments() {
        return $this->hasMany(TrainerDocument::class, 'trainer_id', 'id');
    }

    function trainerQualifications() {
        return $this->hasMany(UserQualification::class, 'user_id', 'id');
    }

    function trainerSpecializations() {
        return $this->hasMany(UserSpecialization::class, 'user_id', 'id');
    }

    function trainerAppointments() {
        return $this->hasMany(Appointment::class, 'trainer_id', 'id');
    }

    function usedPass() {
        return $this->hasMany(Appointment::class, 'client_id', 'id')->where('status', 'accepted');
    }
     
    function userQuestion1() {
        return $this->hasOne(QuestionAnswer::class, 'user_id', 'id')->where('question', 'user_question1');
    }

    function userQuestion2() {
        return $this->hasOne(QuestionAnswer::class, 'user_id', 'id')->where('question', 'user_question2');
    }

    function userQuestion3() {
        return $this->hasOne(QuestionAnswer::class, 'user_id', 'id')->where('question', 'user_question3');
    }
    function trainerQuestion1() {
        return $this->hasOne(QuestionAnswer::class, 'user_id', 'id')->where('question', 'question1');
    }

    function trainerQuestion2() {
        return $this->hasOne(QuestionAnswer::class, 'user_id', 'id')->where('question', 'question2');
    }

    function trainerQuestion3() {
        return $this->hasOne(QuestionAnswer::class, 'user_id', 'id')->where('question', 'question3');
    }
    
    function userFitness() {
        return $this->hasMany(UserFitnessGoal::class, 'user_id', 'id');
    }

    function trainerTimeTable() {
        return $this->hasMany(TrainerTimetable::class, 'trainer_id', 'id');
    }
    
    function getTrainerRating() {
        return $this->hasMany(Rating::class, 'user_id', 'id');
    }
}
