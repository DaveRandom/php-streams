<?php

class Datagram
{
    /**
     * @var string
     */
    private $data;

    /**
     * @var string
     */
    private $remoteAddr;

    /**
     * Constructor
     *
     * @todo Probably shouldn't exist in native impl
     *
     * @param $data
     * @param $remoteAddr
     */
    public function __construct($data, $remoteAddr)
    {
        $this->data = $data;
        $this->remoteAddr = $remoteAddr;
    }

    /**
     * Get the data payload of the datagram, to play nice with ReadableStream
     *
     * @return string
     */
    public function __toString()
    {
        return $this->data;
    }

    /**
     * Get the data payload of the datagram
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the remote address associated with the datagram
     *
     * @return string
     */
    public function getRemoteAddr()
    {
        return $this->remoteAddr;
    }
}
