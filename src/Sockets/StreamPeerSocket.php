<?php

class StreamPeerSocket extends StreamSocket implements ReadableStream, WriteableStream, EncryptableStream
{
    /**
     * Constructor
     *
     * @param string $uri
     * @param array $options
     */
    public function __construct($uri, $options)
    {

    }

    /**
     * Enable encryption on a stream
     *
     * @param int $type
     * @param EncryptableStream $sessionSteam
     * @return int|bool
     */
    public function enableEncryption($type = null, EncryptableStream $sessionSteam = null)
    {
        // TODO: Implement enableEncryption() method.
    }

    /**
     * Disable encryption on a stream
     *
     * @return int|bool
     * @todo look into possible return values here
     */
    public function disableEncryption()
    {
        // TODO: Implement disableEncryption() method.
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
