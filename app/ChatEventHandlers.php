<?php

namespace App;


use Ratchet\ConnectionInterface;

trait ChatEventHandlers
{
    protected function handleJoined(ConnectionInterface $from, $payload)
    {
        $this->users[$from->resourceId] = $payload->data->user;
        var_dump($this->users);
    }
}