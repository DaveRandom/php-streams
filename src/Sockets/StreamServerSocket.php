<?php

class StreamServerSocket extends StreamSocket
{
    /**
     * Constructor creates and binds the socket
     *
     * @param string $uri
     * @param array $options
     * @throws \LogicException
     * @throws \RuntimeException
     */
    public function __construct($uri, array $options = [])
    {
        $ctx = stream_context_create($options);

        $this->socket = stream_socket_server($uri, $errNo, $errStr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $ctx);
        if (!$this->socket) {
            throw new \RuntimeException('Failed to create stream server on ' . $uri . ': ' . $errNo . ': ' . $errStr);
        }
    }

    /**
     * Accept a pending client connection on a stream
     *
     * @param float $timeout
     * @return StreamPeerSocket|null
     */
    public function accept($timeout = null)
    {
        if ($client = stream_socket_accept($this->socket, $timeout)) {
            $className = $this->getOption('socket', 'client_class');
            return new $className($client);
        }

        return null;
    }

    /**
     * Set the value of an option
     *
     * @param int $family
     * @param int $option
     * @param mixed $value
     * @throws LogicException
     */
    public function setOption($family, $option, $value)
    {
        if ($family === 'socket' && $option === 'client_class') {
            $value = (string)$value;

            if (!is_subclass_of($value, 'StreamPeerSocket')) {
                throw new \LogicException('Client class must extend StreamPeerSocket');
            }
        }

        parent::setOption($family, $option, $value);
    }
}
