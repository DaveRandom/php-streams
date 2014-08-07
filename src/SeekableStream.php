<?php

interface SeekableStream
{
    /**
     * Sets the position indicator to a specified position
     *
     * @param int $offset
     * @param int $whence
     * @return bool
     */
    public function seek($offset, $whence = SEEK_SET);

    /**
     * Sets the position indicator to the beginning of the stream
     *
     * @return bool
     */
    public function rewind();
}
