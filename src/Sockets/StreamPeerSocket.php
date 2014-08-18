<?php

class StreamPeerSocket extends StreamSocket implements ReadableStream, WriteableStream, EncryptableStream
{
    /**
     * Constructor
     *
     * @param string $uri
     * @param array $options
     * @throws \LogicException
     * @throws \RuntimeException
     */
    public function __construct($uri, array $options = [])
    {
        if (is_resource($uri)) {
            $this->socket = $uri;
            return;
        }

        $uriParts = $this->parseURI($uri);
        if ($uriParts['scheme'] === 'unix' && !isset($uriParts['path'])) {
            throw new \LogicException('Invalid URI: The unix:// scheme requires a path component');
        } else if ($uriParts['scheme'] !== 'unix' && !isset($uriParts['host'], $uriParts['port'])) {
            throw new \LogicException(
                'Invalid URI: The ' . $uriParts['scheme'] . ':// scheme requires host and port components'
            );
        }

        $timeout = $this->getOption('socket', 'connect_timeout');
        if ($timeout === null) {
            $timeout = ini_get('default_socket_timeout');
        }
        $flags = STREAM_CLIENT_CONNECT;
        if ($this->getOption('socket', 'async_connect')) {
            $flags |= STREAM_CLIENT_ASYNC_CONNECT;
        }
        if ($this->getOption('socket', 'persistent')) {
            $flags |= STREAM_CLIENT_PERSISTENT;
        }
        $ctx = stream_context_create($options);

        $this->socket = stream_socket_client($uri, $errNo, $errStr, (float)$timeout, $flags, $ctx);
        if (!$this->socket) {
            throw new \RuntimeException('Failed to create stream client on ' . $uri . ': ' . $errNo . ': ' . $errStr);
        }
    }

    /**
     * Enable encryption on a stream
     *
     * @param int $type
     * @param EncryptableStream $sessionSteam
     * @return int|bool
     * @throws \LogicException when OpenSSL is not loaded
     */
    public function enableEncryption($type = null, EncryptableStream $sessionSteam = null)
    {
        if (!function_exists('stream_socket_enable_crypto')) {
            throw new \LogicException('Cannot enable encryption on the stream, OpenSSL is not loaded.');
        }

        if ($sessionSteam) {
            $sessionSteam = (new \ReflectionObject($sessionSteam))
                ->getProperty('socket')
                ->getValue();
        }

        return stream_socket_enable_crypto($this->socket, true, $type, $sessionSteam);
    }

    /**
     * Disable encryption on a stream
     *
     * @return int|bool
     */
    public function disableEncryption()
    {
        return stream_socket_enable_crypto($this->socket, false);
    }

    /**
     * Read up to $length bytes of data from the stream
     *
     * @see fread()
     * @see stream_get_contents()
     * @param int $length
     * @return string|false
     */
    public function read($length = null)
    {
        // TODO: Implement read() method.
    }

    /**
     * Read a line from the stream
     *
     * @see fgets()
     * @see stream_get_line()
     * @param int $length
     * @param string $ending
     * @return string|false
     */
    public function readLine($length = null, $ending = null)
    {
        // TODO: Implement readLine() method.
    }

    /**
     * Copy data from this stream to another until EOF
     *
     * @see stream_copy_to_stream()
     * @param WriteableStream $stream
     */
    public function pipeTo(WriteableStream $stream)
    {
        // TODO: Implement pipeTo() method.
    }

    /**
     * @return bool
     */
    public function isEOF()
    {
        // TODO: Implement isEOF() method.
    }

    /**
     * Write up to $length bytes of data to the stream
     *
     * @see fwrite()
     * @see stream_copy_to_stream()
     * @param string|ReadableStream $data
     * @param int $length
     * @return int|false
     */
    public function write($data, $length = null)
    {
        // TODO: Implement write() method.
    }
}
