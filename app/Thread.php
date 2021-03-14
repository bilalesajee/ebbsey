<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Thread extends Model {

    function sender() {
        return $this->hasOne(User::class, 'id', 'sender_id')->select(['id', 'first_name','last_name', 'image']);
    }

    function receiver() {
        return $this->hasOne(User::class, 'id', 'receiver_id')->select(['id', 'first_name','last_name' ,'image']);
    }

    function lastMessage() {
        return $this->hasOne(Message::class, 'id', 'last_message_id');
    }

    function messages() {
        return $this->hasMany(Message::class, 'thread_id');
    }

}
