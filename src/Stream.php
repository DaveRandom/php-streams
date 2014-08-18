<?php

abstract class Stream
{
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
    abstract public function close();

    /**
     * Set the value of an option on a stream
     *
     * @param string $family
     * @param string $option
     * @param mixed $value
     */
    public function setOption($family, $option, $value)
    {
        $this->options[(string)$family][(string)$option] = $value;
    }

    /**
     * Get the value of an option on a stream
     *
     * @param string $family
     * @param string $option
     * @return mixed
     */
    public function getOption($family, $option)
    {
        return isset($this->options[$family][$option]) ? $this->options[$family][$option] : null;
    }
}
