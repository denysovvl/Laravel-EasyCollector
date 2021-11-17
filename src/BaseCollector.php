<?php

namespace Denysovvl\EasyCollector;

use Exception;
use Illuminate\Support\Collection;

abstract class BaseCollector implements Collectable
{
    protected $elements;

    protected $collector;

    /**
     * @throws Exception
     */
    public function __construct($elements, $args)
    {
        if (!is_iterable($elements)) {
            throw new Exception(static::class . ': Given element must be iterable, [' . gettype($elements) . '] given.');
        }

        if (is_array($elements)) {
            $elements = json_decode(json_encode($elements));
        }

        $this->elements = $elements;

        $this->collector = new ArgsCollector($this->defaultArgsValue());

        $this->setArgs($args);
    }

    /**
     * Sets additional args to ArgsCollector
     *
     * @param $args
     */
    private function setArgs($args)
    {
        if (!$args) {
            return ;
        }

        foreach ($args as $key => $value) {
            $this->collector->{$key} = $value;
        }
    }

    /**
     * Create an array from elements.
     *
     * @return array
     */
    private function getArray(): array
    {
        $array = [];

        foreach ($this->elements as $element) {
            $array[] = $this->collect($element, $this->collector);
        }

        return $array;
    }

    /**
     * Create an object from elements.
     *
     * @return array
     */
    private function getObject(): array
    {
        return json_decode(json_encode($this->getArray()));
    }

    /**
     * Create a collection from elements.
     *
     * @return Collection
     */
    private function getCollection(): Collection
    {
        return collect($this->getObject());
    }

    /**
     * Sets default value for ArgsCollector if needed key is not present
     *
     * @return null
     */
    public function defaultArgsValue()
    {
        return null;
    }

    /**
     * Creates instance of child class and returns array representation of collector.
     *
     * @param mixed $elements
     * @return array
     * @throws Exception
     */
    public static function toArray($elements, $args = null): array
    {
        return (new static($elements, $args))->getArray();

    }

    /**
     * Creates instance of child class and returns collection representation of collector.
     *
     * @param mixed $elements
     * @return Collection
     * @throws Exception
     */
    public static function toCollection($elements, $args = null): Collection
    {
        return (new static($elements, $args))->getCollection();
    }

    /**
     * Creates instance of child class and returns object representation of collector.
     *
     * @param mixed $elements
     * @return array
     * @throws Exception
     */
    public static function toObject($elements, $args = null): array
    {
        return (new static($elements, $args))->getObject();
    }

}
