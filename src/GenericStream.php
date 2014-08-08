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
     * @param int $option
     * @param mixed $value
     * @throws \LogicException when invalid option is specified
     */
    public function setOption($option, $value);

    /**
     * Get the value of an option on a stream
     *
     * @param int $option
     * @return mixed
     * @throws \LogicException when invalid option is specified
     */
    public function getOption($option);
}
