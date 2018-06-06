<?php

namespace App\Socket;


use App\Events\Event;

class Broadcast
{

    protected $event;

    protected $clients;

    public function __construct(Event $event, array $clients)
    {
        $this->event = $event;
        $this->clients = $clients;
    }

    public function toAll()
    {
        foreach ($this->clients as $client) {
            $client->send($this->event);
        }
    }
}