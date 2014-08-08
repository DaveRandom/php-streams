<?php

interface WriteableStream
{
    /**
     * Write up to $length bytes of data to the stream
     *
     * @see fwrite()
     * @see stream_copy_to_stream()
     * @param string|ReadableStream $data
     * @param int $length
     * @return int|false
     */
    public function write($data, $length = null);
}

#murica
class_alias('WriteableStream', 'WritableStream');
