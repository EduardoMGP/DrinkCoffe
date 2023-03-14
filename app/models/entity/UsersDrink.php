<?php

namespace App\Models\Entity;

class UsersDrink extends Entity
{


    private ?int $id;
    private ?string $user_id;
    private ?string $drink;
    private ?string $created_at;

    public static function toObject($array = [])
    {
        if (empty($array)) {
            return null;
        }

        $user_drink = new UsersDrink();
        $user_drink->id = $array['id'] ?? null;
        $user_drink->user_id = $array['user_id'] ?? null;
        $user_drink->drink = $array['drink'] ?? null;
        $user_drink->created_at = $array['created_at'] ?? null;

        return $user_drink;
    }

    public function toArray()
    {
        return [
            'id'         => $this->id,
            'user_id'       => $this->user_id,
            'drink'      => $this->drink,
            'created_at' => $this->created_at,
        ];
    }


}