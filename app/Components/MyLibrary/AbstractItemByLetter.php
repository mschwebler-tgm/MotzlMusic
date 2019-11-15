<?php

namespace App\Components\MyLibrary;

use Illuminate\Support\Collection;

abstract class AbstractItemByLetter implements \JsonSerializable
{
    private $letter;
    private $count;
    protected $items;

    public function __construct($firstLetterOccurrence)
    {
        $this->letter = $firstLetterOccurrence->firstLetter;
        $this->count = $firstLetterOccurrence->count;
    }

    abstract public function loadIds();

    public function getLetter()
    {
        return $this->letter;
    }

    public function setLetter($letter)
    {
        $this->letter = $letter;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
