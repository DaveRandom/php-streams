<?php

class DatagramClientSocket extends DatagramSocket implements ReadableStream, WriteableStream
{
    /**
     * Get a list of the URI schemes that this type of stream can handle
     *
     * @return array
     */
    protected function getSupportedSchemes()
    {
        static $schemes = null;

        if ($schemes === null) {
            $schemes = ['udp'];

            if (in_array('udg', stream_get_transports())) {
                $schemes[] = 'udg';
            }
        }

        return $schemes;
    }

    /**
     * Constructor
     *
     * Create and bind the local socket
     *
     * @param string $uri
     * @param array $options
     * @throws \LogicException when an unsupported URI is supplied
     * @throws \RuntimeException when creating the socket fails
     * @todo add option handling
     */
    public function __construct($uri, array $options = [])
    {
        $uriParts = $this->parseURI($uri);

        if ($uriParts['scheme'] === 'udp' && !isset($uriParts['host'], $uriParts['port'])) {
            throw new \LogicException('udp:// URIs require host and port components');
        } else if ($uriParts['scheme'] === 'udg' && !isset($uriParts['path'])) {
            throw new \LogicException('udg:// URIs require a path component');
        }

        $this->socket = stream_socket_client($uri, $errNo, $errStr);
        if (!$this->socket) {
            throw new \RuntimeException('Creating socket failed: ' . $errNo . ': ' . $errStr);
        }
    }

    /**
     * Read up to $length bytes of data from the stream
     *
     * @see fread()
     * @see stream_get_contents()
     * @param int $length
     * @return string|false
     */
    public function read($length = 1024) //todo: ensure default value 1024 is sane
    {
        $datagram = $this->recv((int)$length);
        return $datagram ? $datagram->data : false;
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
    public function readLine($length = null, $ending = "\n")
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
        // TODO: Implement pipeTo() method. Not sure if this is actually sanely possible with datagrams
    }

    /**
     * @return bool
     */
    public function isEOF()
    {
        // TODO: Implement isEOF() method. Only true when closed locally?
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
