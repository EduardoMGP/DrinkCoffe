<?php

use Mosyle\IValidator;

class LoginValidator implements IValidator
{

    public static function validate($data = [])
    {
        return [
            'email' => [
                'required' => true,
                'regex'    => '/[a-z0-9]+@[a-z]+\.[a-z]{2,3}/m', // optional
                'error' => [
                    'required' => 'Email is required',
                    'regex'    => 'Email or password is incorrect',
                ]
            ],

            'password' => [
                'required' => true,
                'regex'    => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/m', // optional
                'error' => [
                    'required' => 'Password is required',
                    'regex'    => 'Email or password is incorrect',
                ]
            ],

        ];
    }

}