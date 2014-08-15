<?php

/**
 * Class Datagram
 *
 * @property-read string $data
 * @property-read string $remoteAddress
 */
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
     * @param $data
     * @param $remoteAddr
     */
    public function __construct($data, $remoteAddr)
    {
        $this->data = (string)$data;
        $this->remoteAddr = (string)$remoteAddr;
    }

    /**
     * Magic getter for properties
     *
     * Userland implementation detail of read-only properties, does not exist in native implementation
     *
     * @param $name
     * @return string
     */
    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     * Get the data payload of the datagram
     *
     * @todo maybe should not exist?
     * @return string
     */
    public function __toString()
    {
        return $this->data;
    }
}
