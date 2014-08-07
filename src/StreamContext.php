<?php

class StreamContext
{
    /**
     * Internal array of options
     *
     * @var array
     */
    private $options = [];

    /**
     * Constructor
     *
     * @param array|GenericStream|StreamContext $options
     * @throws \LogicException when the option format is invalid
     */
    public function __construct($options = null)
    {
        if ($options !== null) {
            if ($options instanceof GenericStream) {
                $options = $options->context->getOptions();
            } else if ($options instanceof StreamContext) {
                $options = $options->getOptions();
            } else {
                $options = (array)$options;
            }

            $this->setOptionsFromArray($options);
        }
    }

    /**
     * Assign options from an input array to the internal option store
     *
     * @param array $options
     * @throws LogicException when the option format is invalid
     */
    private function setOptionsFromArray(array $options)
    {
        foreach ($options as $wrapperName => $wrapperOptions) {
            if (!is_string($wrapperName)) {
                throw new \LogicException('Invalid context option format: wrapper names must be strings');
            }

            foreach ((array)$wrapperOptions as $optionName => $optionValue) {
                if (!is_string($optionName)) {
                    throw new \LogicException('Invalid context option format: option names must be strings');
                }

                $this->options[$wrapperName][$optionName] = $optionValue;
            }
        }
    }

    /**
     * Get a specific option, all of a specific wrapper's options or all options
     *
     * @param string $wrapper
     * @param string $option
     * @return mixed
     */
    public function getOptions($wrapper = null, $option = null) {
        if ($wrapper !== null) {
            if ($option !== null) {
                return isset($this->options[$wrapper][$option]) ? $this->options[$wrapper][$option] : null;
            }

            return isset($this->options[$wrapper]) ? $this->options[$wrapper] : null;
        }

        return $this->options;
    }

    /**
     * Set a specific option, a specific wrappers options or all options
     *
     * @param string|array $arg1
     * @param string|array $arg2
     * @param mixed $arg3
     * @throws \LogicException when the option format is invalid
     */
    public function setOptions($arg1, $arg2 = null, $arg3 = null)
    {
        if ($arg2 === null) {
            $this->setOptionsFromArray($arg1);
        }

        if ($arg3 === null) {
            $this->setOptionsFromArray([$arg1 => $arg2]);
        }

        $this->setOptionsFromArray([$arg1 => [$arg2 => $arg3]]);
    }
}
