<?php

namespace App\Models\Table;

use App\Models\EncryptTrait;
use App\Models\Entity\UsersToken;
use Exception;
use Mosyle\DB;

class UsersTokenTable extends Table
{

    use EncryptTrait;

    /**
     * @param string $token
     * @return UsersToken
     * @throws Exception
     */
    public static function validateToken($token)
    {
        $sql = "SELECT * FROM users_token right join users on users.id = users_token.user_id WHERE token = :token AND expired_at > NOW() AND ip = :ip";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":token", str_replace('Bearer ', '', $token));
        $stmt->bindValue(":ip", $_SERVER['REMOTE_ADDR']);
        $stmt->execute();
        $user_token = $stmt->fetch(\PDO::FETCH_ASSOC);
        return UsersToken::toObject($user_token);
    }

    /**
     * @param int $user_id
     * @return string
     * @throws Exception
     */
    public static function generateToken(int $user_id)
    {
        self::deleteAllTokens($user_id);

        $token = openssl_random_pseudo_bytes(132);
        $accessToken = base64_encode($token);

        $sql = "INSERT INTO users_token (user_id, token, user_agent, ip, expired_at) VALUES (:user_id, :token, :user_agent, :ip, :expired_at)";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":token", $accessToken);
        $stmt->bindValue(":user_agent", $_SERVER['HTTP_USER_AGENT']);
        $stmt->bindValue(":ip", $_SERVER['REMOTE_ADDR']);
        $stmt->bindValue(":expired_at", date('Y-m-d H:i:s', strtotime('+30 minutes')));
        $stmt->execute();
        return $accessToken;
    }

    /**
     * @param $token
     * @throws Exception
     */
    public static function deleteToken($token)
    {
        $sql = "DELETE FROM users_token WHERE token = :token";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":token", $token);
        $stmt->execute();
    }

    /**
     * @param $user_id
     * @throws Exception
     */
    public static function deleteAllTokens($user_id)
    {
        $sql = "DELETE FROM users_token WHERE user_id = :user_id";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
    }

    /**
     * @throws Exception
     */
    public static function deleteAllExpiredToken()
    {
        $sql = "DELETE FROM users_token WHERE expired_at < NOW()";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute();
    }

}