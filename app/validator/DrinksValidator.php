<?php

use Mosyle\IValidator;

class DrinksValidator implements IValidator
{

    public static function validate($data = [])
    {
        return [
            'drink' => [
                'required' => false,
                'regex'    => '/^[0-9]+$/', // optional
                'error' => [
                    'regex'    => 'Drink must be a number',
                ]
            ]
        ];
    }

}