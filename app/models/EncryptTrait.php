<?php

namespace App\Models;

trait EncryptTrait
{

    private static function salt()
    {
        return uniqid();
    }

    public static function hash($password, $salt = null)
    {
        if ($password != null) {
            if ($salt == null) {
                $salt = self::salt();
            }
            return strrev(sha1(md5($password) . strrev($salt)) . $salt);
        }
    }

    public static function verify($password, $hash)
    {
        $salt = substr(strrev($hash), 40, strlen($hash));
        return self::hash($password, $salt) == $hash;
    }

}