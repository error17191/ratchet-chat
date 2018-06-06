<?php

namespace App\Events;


class UserJoined extends Event
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function eventName()
    {
        return 'joined';
    }

    public function data()
    {
        return [
            'user' => $this->user
        ];
    }
}