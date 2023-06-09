<?php

namespace App\Models\Table;

use App\Models\EncryptTrait;
use App\Models\Entity\User;
use Mosyle\Collections;
use Mosyle\DB;
use PDO;

class UsersTable extends Table
{

    use EncryptTrait;

    /**
     * @return int
     */
    public static function count()
    {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * @return Collections
     */
    public static function all($page = 0)
    {

        $sql = "SELECT id, name, email, drink, created_at, updated_at FROM users LIMIT 5 OFFSET :page";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":page", intval($page * 5), PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return new Collections(User::class, $users);

    }

    /**
     * @param $email
     * @return User|null
     */
    public static function getByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return User::toObject($user);
    }

    /**
     * @param $id
     * @return User|null
     */
    public static function get($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return User::toObject($user);
    }

    /**
     * @param User $user
     * @return User
     * @throws \Exception
     */
    public static function create(User $user)
    {
        $hash = self::hash($user->password());
        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":name", $user->name());
        $stmt->bindValue(":email", $user->email());
        $stmt->bindValue(":password", $hash);
        $stmt->bindValue(":role", $user->role() ?? 'user');
        $stmt->execute();
        return $user->setId(DB::pdo()->lastInsertId());
    }

    public static function createNotExists(array $array)
    {
        $user = self::getByEmail($array['email']);
        if (!$user) {
            $user = new User();
            $user->setName($array['name']);
            $user->setEmail($array['email']);
            $user->setPassword($array['password']);
            $user->setRole($array['role']);
            self::create($user);
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public static function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }

    /**
     * @param $id
     * @param User $user
     * @return User
     * @throws \Exception
     */
    public static function update(User $user)
    {
        $sql = "UPDATE users SET role = :role, drink = (select coalesce(sum(drink), 0) from users_drink where user_id = :user_id), email = :email, password = :password, name = :name WHERE id = :id";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":id", $user->id());
        $stmt->bindValue(":user_id", $user->id());
        $stmt->bindValue(":email", $user->email());
        $stmt->bindValue(":password", $user->password());
        $stmt->bindValue(":name", $user->name());
        $stmt->bindValue(":role", $user->role() ?? 'user');
        $stmt->execute();
        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public static function getByCredentials(string $email, string $password)
    {
        $user = self::getByEmail($email);
        if ($user && self::verify($password, $user->password())) {
            return $user;
        }
        return null;
    }

}