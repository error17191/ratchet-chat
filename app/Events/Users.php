<?php

namespace App\Events;


class Users extends Event
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function eventName()
    {
        return 'users';
    }

    public function data()
    {
        return [
            'users' => array_values($this->users)
        ];
    }
}