<?php

namespace App\Socket;


use App\Events\Event;

abstract class SocketAbstract
{
    protected function broadcast(Event $event)
    {
        return new Broadcast($event, $this->clients);
    }
}