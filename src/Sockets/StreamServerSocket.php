<?php

class StreamServerSocket implements GenericStream
{
    const OPTION_CLIENT_CLASS = 1;

    /**
     * Defined option values
     *
     * @var array
     */
    private $options = [
        self::OPTION_CLIENT_CLASS => 'StreamPeerSocket',
    ];

    /**
     * @var resource
     */
    private $stream;

    /**
     * Constructor creates and binds the socket
     *
     * @param string $uri
     * @param array $options
     * @throws \RuntimeException
     */
    public function __construct($uri, array $options = [])
    {
        $ctx = stream_context_create($options);

        $this->stream = stream_socket_server($uri, $errNo, $errStr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $ctx);
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
            $className = $this->options[self::OPTION_CLIENT_CLASS];
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
        switch ($option) {
            case self::OPTION_CLIENT_CLASS:
                $value = (string)$value;
                if (!is_subclass_of($value, 'StreamPeerSocket')) {
                    throw new \LogicException('Client class must extend StreamPeerSocket');
                }
                break;

            default:
                throw new \LogicException('Unknown option: ' . $option);
        }

        $this->options[$option] = $value;
    }

    /**
     * Get the value of an option
     *
     * @param string $family
     * @param int $option
     * @throws LogicException
     * @return mixed
     */
    public function getOption($family, $option)
    {
        switch ($option) {
            case self::OPTION_CLIENT_CLASS:
                return isset($this->options[$option]) ? $this->options[$option] : null;

            default:
                throw new \LogicException('Unknown option: ' . $option);
        }
    }
}
