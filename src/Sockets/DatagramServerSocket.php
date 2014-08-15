<?php

class DatagramServerSocket extends DatagramSocket implements ReadableStream
{
    /**
     * Constructor
     *
     * Create and bind the local socket
     *
     * @param $uri
     * @param array $options
     */
    public function __construct($uri, array $options = [])
    {
        // TODO: Implement ctor
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
}
