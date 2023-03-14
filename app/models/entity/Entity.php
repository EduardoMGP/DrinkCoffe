<?php

namespace App\Models\Entity;

abstract class Entity
{
    abstract public function toArray();
    abstract public static function toObject($array = []);
}