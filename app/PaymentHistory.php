<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model {

    function client() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function trainer() {
        return $this->hasOne(User::class, 'id', 'trainer_id');
    }

    function classData() {
        return $this->hasOne(Classes::class, 'id', 'class_id');
    }

    function appointment() {
        return $this->hasOne(Appointment::class, 'id', 'appointment_id');
    }

}
