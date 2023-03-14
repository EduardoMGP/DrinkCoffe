<?php

namespace App\Models\Table;

use App\Models\Entity\User;
use Exception;
use Mosyle\DB;

class UsersDrinksTable extends Table
{

    /**
     * @param User $user
     * @param int $drink
     * @throws Exception
     */
    public static function drink(User $user, int $drink)
    {
        $sql = "INSERT INTO users_drink (user_id, drink) VALUES (:user_id, :drink)";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":user_id", $user->id());
        $stmt->bindValue(":drink", $drink);
        $stmt->execute();
        UsersTable::update($user);
        $user->setDrink($user->drink() + $drink);
    }

    /**
     * @param int $period_days
     * @return array
     */
    public static function getRankingDrinkersInPeriod(int $period_days)
    {
        $sql = "SELECT users.id, users.name, users.email, SUM(users_drink.drink) AS total
                FROM users_drink
                INNER JOIN users ON users_drink.user_id = users.id
                WHERE DATE(users_drink.created_at) BETWEEN CURDATE() - INTERVAL :period_days DAY AND CURDATE()
                GROUP BY users.id
                ORDER BY total DESC;";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":period_days", $period_days);
        $stmt->execute();
        return [
            'period_days' => $period_days,
            'ranking' => $stmt->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    /**
     * @param string $date
     * @return array
     */
    public static function getRankingDrinkersInDate(string $date)
    {
        $date = date('Y/m/d', strtotime(str_replace('/', '-', $date)));
        $sql = "SELECT users.id, users.name, users.email, SUM(users_drink.drink) AS total
                FROM users_drink
                INNER JOIN users ON users_drink.user_id = users.id
                WHERE DATE(users_drink.created_at) = :date
                GROUP BY users.id
                ORDER BY total DESC;";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":date", $date);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return [
            'date' => $date,
            'ranking' => $data
        ];
    }

    /**
     * @param $user_id
     * @return array
     */
    public static function drinkPerDay($user_id)
    {
        $sql = "SELECT users.*, SUM(users_drink.drink) as total, DATE_FORMAT(users_drink.created_at, '%d/%m/%Y') as date FROM users_drink 
                RIGHT JOIN users ON users.id = users_drink.user_id
                WHERE user_id = :user_id
                GROUP BY DATE_FORMAT(users_drink.created_at, '%d/%m/%Y')";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        $drinks = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $drinks_per_day = [];
        if (!empty($drinks)) {
            $user = $drinks[0];
            foreach ($drinks as $key => $drink) {
                $drinks_per_day[$key]['date'] = $drink['date'];
                $drinks_per_day[$key]['drink'] = intval($drink['total']);
            }
        }

        return [
            'user'   => isset($user) ? [
                'id'    => $user_id,
                'drink' => $user['drink'],
                'name'  => $user['name'],
                'email' => $user['email']
            ] : [],
            'drinks' => $drinks_per_day
        ];
    }

}