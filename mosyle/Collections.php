<?php

namespace Mosyle;

class Collections
{

    private $items = [];
    private $type;

    public function __construct($type, $items = [])
    {
        $this->items = $items;
        $this->type = $type;
    }

    public function count()
    {
        return count($this->items);
    }

    public function first()
    {
        return $this->items[0];
    }

    public function last()
    {
        return $this->items[$this->count() - 1];
    }

    public function toArray()
    {
        return $this->items;
    }

    public function toObject()
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $this->type::arrayToObject($item);
        }
        return $items;
    }
}