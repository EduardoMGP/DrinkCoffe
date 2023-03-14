<?php

use Mosyle\IValidator;

class UsersValidator implements IValidator
{

    public static function validate($data = [])
    {
        return [
            'name' => [
                'required' => true,
                'min'      => 3,
                'max'      => 255,
                'regex'    => '/^[a-zA-Z0-9 ]*$/m', // optional
                'error' => [
                    'required' => 'Name is required',
                    'min'      => 'Name must be at least {min} characters',
                    'max'      => 'Name must be at most {max} characters',
                    'regex'    => 'Name must contain only letters, numbers and spaces',
                ]
            ],

            'email' => [
                'required' => true,
                'min'      => 3,
                'max'      => 255,
                'regex'    => '/[a-z0-9]+@[a-z]+\.[a-z]{2,3}/m', // optional
                'error' => [
                    'required' => 'Email is required',
                    'min'      => 'Email must be at least {min} characters',
                    'max'      => 'Email must be at most {max} characters',
                    'regex'    => 'Email must be a valid email address',
                ]
            ],

            'password' => [
                'required' => true,
                'min'      => 8,
                'max'      => 255,
                'regex'    => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/m', // optional
                'error' => [
                    'required' => 'Password is required',
                    'min'      => 'Password must be at least {min} characters',
                    'max'      => 'Password must be at most {max} characters',
                    'regex'    => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character',
                ]
            ],
        ];
    }

}