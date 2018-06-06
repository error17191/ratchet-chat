<?php

namespace App;


use App\Events\UserJoined;
use Ratchet\ConnectionInterface;

trait ChatEventHandlers
{
    protected function handleJoined(ConnectionInterface $from, $payload)
    {
        $this->users[$from->resourceId] = $payload->data->user;
        $this->broadcast(new UserJoined($payload->data->user))->toAll();

//        foreach ($this->clients as $client) {
//            $client->send(json_encode([
//                'event' => 'joined',
//                'data' => [
//                    'user' => $payload->data->user
//                ]
//            ]));
//        }
    }
}