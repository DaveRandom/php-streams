<?php

abstract class Stream
{
    /**
     * Underlying socket resource
     *
     * @var resource
     */
    protected $stream;

    /**
     * Options that have been set on the stream
     *
     * @var array
     */
    private $options = [];

    /**
     * Close the stream
     *
     * @throws \LogicException when the underlying stream has already been closed
     * @throws \RuntimeException when the close operation fails
     */
    public function close()
    {
        if ($this->stream === null) {
            throw new \LogicException('Failed to close stream: already closed');
        } else if (!fclose($this->stream)) {
            throw new \RuntimeException('Failed to close stream: operation failed');
        }

        $this->stream = null;
    }

    /**
     * Set the value of an option on a stream
     *
     * @param string $option
     * @param mixed $value
     * @internal param string $family
     */
    public function setOption($option, $value)
    {
        $this->options[(string)$option] = $value;
    }

    /**
     * Get the value of an option on a stream
     *
     * @param string $option
     * @internal param string $family
     * @return mixed
     */
    public function getOption($option)
    {
        $option = (string)$option;
        return isset($this->options[$option]) ? $this->options[$option] : null;
    }

    /**
     * Get the meta data for this stream
     *
     * @see stream_get_meta_data()
     * @return StreamMetaData
     * @todo not very nice, try and come up with a way to expose this info in a nicer way
     */
    public function getMetaData()
    {
        $data = stream_get_meta_data($this->stream);

        $result = new StreamMetaData;
        $result->blocked     = $data['blocked'];
        $result->eof         = $data['eof'];
        $result->mode        = $data['mode'];
        $result->seekable    = $data['seekable'];
        $result->streamType  = $data['stream_type'];
        $result->timedOut    = $data['timed_out'];
        $result->unreadBytes = $data['unread_bytes'];
        $result->uri         = $data['uri'];
        $result->wrapperData = $data['wrapper_data'];
        $result->wrapperType = $data['wrapper_type'];

        return $result;
    }
}
