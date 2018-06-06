<?php

namespace App;


use App\Events\UserJoined;
use App\Events\Users;
use Ratchet\ConnectionInterface;

trait ChatEventHandlers
{
    protected function handleJoined(ConnectionInterface $from, $payload)
    {
        $user = $payload->data->user;;
        $this->users[$from->resourceId] = $user;

        $this->broadcast(new UserJoined($payload->data->user))->toAllExcept($from);
        $this->broadcast(new Users($this->users))->to($from);
    }
}