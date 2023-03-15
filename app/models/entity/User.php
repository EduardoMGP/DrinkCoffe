<?php

namespace App\Models\Entity;

use App\Models\EncryptTrait;

class User extends Entity
{

    use EncryptTrait;

    private ?int $id;
    private ?string $name;
    private ?string $email;
    private ?string $password;
    private ?int $drink;
    private ?string $role;
    private ?string $created_at;
    private ?string $updated_at;

    public static function toObject($array = [])
    {
        if (empty($array)) {
            return null;
        }

        $user = new User();
        $user->id = $array['id'] ?? null;
        $user->name = $array['name'] ?? null;
        $user->email = $array['email'] ?? null;
        $user->password = $array['password'] ?? null;
        $user->drink = $array['drink'] ?? 0;
        $user->role = $array['role'] ?? 'user';
        $user->created_at = $array['created_at'] ?? null;
        $user->updated_at = $array['updated_at'] ?? null;

        return $user;
    }

    public function toArray()
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'drink'      => $this->drink,
            'role'       => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function password()
    {
        return $this->password;
    }

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return $this->email;
    }

    public function drink()
    {
        return $this->drink;
    }

    public function setId(int $lastInsertId)
    {
        $this->id = $lastInsertId;
        return $this;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setDrink(?int $param)
    {
        $this->drink = $param;
        return $this;
    }

    public function setName(mixed $name)
    {
        $this->name = $name;
        return $this;
    }

    public function setEmail(mixed $email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(mixed $password)
    {
        $this->password = self::hash($password);
        return $this;
    }

    public function role()
    {
        return $this->role;
    }

    public function setRole(mixed $role)
    {
        $this->role = $role;
        return $this;
    }

}