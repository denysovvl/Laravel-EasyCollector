<?php

namespace Denysovvl\EasyCollector;

class ArgsCollector
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var mixed|null
     */
    private $defaultValue;

    public function __construct($defaultValue = null)
    {
        $this->defaultValue = $defaultValue;
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return $this->defaultValue;
    }
}