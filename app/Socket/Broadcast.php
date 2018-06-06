<?php

namespace App\Socket;


use App\Events\Event;
use App\Events\Users;
use Ratchet\ConnectionInterface;

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

    public function to(ConnectionInterface $connection)
    {
        $connection->send($this->event);
    }

    public function toAllExcept(ConnectionInterface $connection)
    {
        foreach ($this->clients as $client) {
            if ($client !== $connection) {
                $client->send($this->event);
            }
        }
    }
}