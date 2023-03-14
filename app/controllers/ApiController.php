<?php

namespace App\Controllers;
use App\Models\Table\UsersTokenTable;

require_once('Controller.php');
class ApiController extends Controller
{

    public function __construct()
    {
        UsersTokenTable::deleteAllExpiredToken();
    }

    /**
     * @return \App\Models\Entity\UsersToken|false
     */
    public function isLogged()
    {
        $header = getallheaders();
        if (isset($header['Authorization'])) {
            $token = $header['Authorization'];
            $user_token = UsersTokenTable::validateToken($token);
            if ($user_token) {
                return $user_token;
            }
        }
        return false;
    }

}