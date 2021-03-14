<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    function sender() {
        return $this->hasOne(User::class, 'id', 'sender_id')->select(['id', 'first_name', 'last_name', 'image']);
    }

    function receiver() {
        return $this->hasOne(User::class, 'id', 'receiver_id')->select(['id', 'first_name', 'last_name', 'image']);
    }

}
