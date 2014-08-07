<?php

interface Stream
{
    /**
     * Read up to $length bytes of data from the stream
     *
     * @see fread()
     * @param int $length
     * @return string|false
     */
    public function read($length);

    /**
     * Read a line from the stream
     *
     * @see fgets()
     * @param int $length
     * @return string|false
     */
    public function readLine($length = null);

    /**
     * Write up to $length bytes of data to the stream
     *
     * @see fwrite()
     * @param string $data
     * @param int $length
     * @return int|false
     */
    public function write($data, $length = null);

    /**
     * Get the context associated with a stream
     *
     * @return StreamContext
     */
    public function getContext();

    /**
     * Set the context associated with a stream
     *
     * @param StreamContext $context
     */
    public function setContext($context);

    /**
     * Copy data from this stream to another until EOF
     *
     * @see stream_copy_to_stream()
     * @param Stream $stream
     * @return mixed
     */
    public function pipeTo(Stream $stream);
}
