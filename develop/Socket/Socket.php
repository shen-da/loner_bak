<?php

declare(strict_types=1);

namespace Loner\Socket;

class Socket
{
    /**
     * Socket constructor.
     * @param ?resource $socket
     */
    public function __construct(private $socket)
    {

    }

    public function accept()
    {

    }

    /**
     * @return resource|null
     */
    public function get()
    {
        return $this->socket;
    }

    public function __destruct()
    {
        fclose($this->socket);
        $this->socket = null;
    }
}
