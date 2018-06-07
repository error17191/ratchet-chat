<?php

namespace App;


use App\Events\UserLeft;
use App\Socket\SocketAbstract;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat extends SocketAbstract implements MessageComponentInterface
{
    use ChatEventHandlers;

    protected $clients = [];

    protected $users = [];

    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->clients[$conn->resourceId] = $conn;
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        if (!isset($this->users[$conn->resourceId])) {
            unset($this->clients[$conn->resourceId]);
            return;
        }

        $user = $this->users[$conn->resourceId];
        $this->broadcast(new UserLeft($user))->toAll();

        unset($this->clients[$conn->resourceId]);
        unset($this->users[$conn->resourceId]);
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, Exception $e)
    {

    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $payload = json_decode($msg);
        if (isset($payload->event) && method_exists($this, $method = 'handle' . ucfirst($payload->event))) {
            $this->$method($from, $payload);
        }
    }
}