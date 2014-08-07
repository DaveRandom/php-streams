<?php

/**
 * Class StreamMetaData
 *
 * @see stream_get_meta_data()
 */
class StreamMetaData
{
    /**
     * TRUE if the stream timed out while waiting for data on the last read operation
     *
     * @var bool
     */
    public $timedOut;

    /**
     * TRUE if the stream is in blocking IO mode
     *
     * @var bool
     */
    public $blocked;

    /**
     * TRUE if the stream has reached end-of-file.
     *
     * Note that for socket streams this member can be TRUE even when unread_bytes is non-zero. To determine if there
     * is more data to be read, use ReadableStream::isEOF() instead of reading this item.
     *
     * @var bool
     */
    public $eof;

    /**
     * The number of bytes currently contained in the PHP's own internal buffer
     *
     * @var int
     */
    public $unreadBytes;

    /**
     * A label describing the underlying implementation of the stream
     *
     * @var string
     */
    public $streamType;

    /**
     * A label describing the protocol wrapper implementation layered over the stream
     *
     * @var string
     */
    public $wrapperType;

    /**
     * Wrapper specific data attached to this stream
     *
     * @var mixed
     */
    public $wrapperData;

    /**
     * The type of access required for this stream
     *
     * @var string
     */
    public $mode;

    /**
     * Whether the current stream can be seeked
     *
     * @var bool
     */
    public $seekable;

    /**
     * The URI/filename associated with this stream
     *
     * @var string
     */
    public $uri;
}
