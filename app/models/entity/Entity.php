<?php

namespace App\Models\Entity;

abstract class Entity
{

    private $errors = null;

    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    public function errors()
    {
        return $this->errors;
    }

    abstract public function toArray();
    abstract public static function toObject($array = []);
}