<?php

namespace Denysovvl\EasyCollector;

use Exception;
use Illuminate\Support\Collection;

abstract class EasyCollector implements Collectable
{
    protected $elements;

    protected $collected;

    /**
     * @throws Exception
     */
    public function __construct($elements)
    {
        if (!is_iterable($elements)) {
            throw new Exception(self::class . ': Given element must be iterable, [' . gettype($elements) . '] given.');
        }

        if (is_array($elements)) {
            $elements = json_decode(json_encode($elements));
        }

        $this->elements = $elements;
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
            $array[] = $this->collect($element);
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
     * Creates instance of child class and returns array representation of collector.
     *
     * @param mixed $elements
     * @return array
     * @throws Exception
     */
    public static function toArray($elements): array
    {
        return (new static($elements))->getArray();

    }

    /**
     * Creates instance of child class and returns collection representation of collector.
     *
     * @param mixed $elements
     * @return Collection
     * @throws Exception
     */
    public static function toCollection($elements): Collection
    {
        return (new static($elements))->getCollection();
    }

    /**
     * Creates instance of child class and returns object representation of collector.
     *
     * @param mixed $elements
     * @return array
     * @throws Exception
     */
    public static function toObject($elements): array
    {
        return (new static($elements))->getObject();
    }

}
