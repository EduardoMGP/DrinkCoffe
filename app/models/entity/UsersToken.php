<?php

namespace App\Models\Entity;

use App\Models\EncryptTrait;

class UsersToken extends Entity
{

    private ?int $id;
    private ?int $user_id;
    private ?string $token;
    private ?string $user_agent;
    private ?string $ip;
    private ?string $expired_at;
    private ?User $user;

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }

    public static function toObject($array = [])
    {
        if (empty($array)) {
            return null;
        }

        $user_token = new UsersToken();
        $user_token->id = $array['id'];
        $user_token->user_id = $array['user_id'];
        $user_token->token = $array['token'];
        $user_token->user_agent = $array['user_agent'];
        $user_token->ip = $array['ip'];
        $user_token->expired_at = $array['expired_at'];
        $user_token->user = User::toObject([
            'id'       => $array['user_id'],
            'name'     => $array['name'],
            'email'    => $array['email'],
            'drink'    => $array['drink'],
            'role'     => $array['role'],
            'password' => $array['password'],
        ]);
        return $user_token;
    }

    public function user()
    {
        return $this->user;
    }


}