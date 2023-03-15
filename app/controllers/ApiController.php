<?php

namespace App\Controllers;

use App\Models\Entity\UsersToken;
use App\Models\Table\UsersTable;
use App\Models\Table\UsersTokenTable;

require_once('Controller.php');

class ApiController extends Controller
{

    public function __construct()
    {
        UsersTokenTable::deleteAllExpiredToken();

        // Create admin user if not exists
        UsersTable::createNotExists([
            'name'     => 'Admin',
            'email'    => 'admin@email.com',
            'password' => 'P4ssw0rd$',
            'role'     => 'admin'
        ]);
    }

    /**
     * @return UsersToken|false
     * @throws \Exception
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