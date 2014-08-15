<?php

/**
 * Interface GenericStream
 *
 * @todo probably does not make sense
 */
interface GenericStream
{
    /**
     * Set the value of an option on a stream
     *
     * @param string $family
     * @param string $option
     * @param mixed $value
     * @return
     */
    public function setOption($family, $option, $value);

    /**
     * Get the value of an option on a stream
     *
     * @param string $family
     * @param string $option
     * @return mixed
     */
    public function getOption($family, $option);

    /**
     * Close the stream and free the underlying resources
     */
    public function close();
}
