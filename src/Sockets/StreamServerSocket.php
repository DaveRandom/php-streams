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
        if (!isset($options['socket.client_class'])) {
            $options['socket.client_class'] = StreamPeerSocket::class;
        }

        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }

        $uriParts = $this->parseURI($uri);
        if ($uriParts['scheme'] === 'unix' && !isset($uriParts['path'])) {
            throw new \LogicException('Invalid URI: The unix:// scheme requires a path component');
        } else if ($uriParts['scheme'] !== 'unix' && !isset($uriParts['host'], $uriParts['port'])) {
            throw new \LogicException(
                'Invalid URI: The ' . $uriParts['scheme'] . ':// scheme requires host and port components'
            );
        }

        $flags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;
        $ctx = stream_context_create($options);

        $this->stream = stream_socket_server($uri, $errNo, $errStr, $flags, $ctx);
        if (!$this->stream) {
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
        if ($client = stream_socket_accept($this->stream, $timeout)) {
            $className = $this->getOption('socket.client_class');
            return new $className($client);
        }

        return null;
    }

    /**
     * Set the value of an option
     *
     * @param int $option
     * @param mixed $value
     * @throws LogicException
     * @internal param int $family
     */
    public function setOption($option, $value)
    {
        if ($option === 'socket.client_class') {
            $value = (string)$value;

            if (!is_subclass_of($value, StreamPeerSocket::class)) {
                throw new \LogicException('Client class must extend ' . StreamPeerSocket::class);
            }
        }

        parent::setOption($option, $value);
    }
}
