<?php

namespace App\Controllers;

use App\Models\Entity\User;
use App\Models\Table\UsersDrinksTable;
use App\Models\Table\UsersTable;
use App\Models\Table\UsersTokenTable;
use DrinksValidator;
use LoginValidator;
use Mosyle\Response;
use UsersEditValidator;
use UsersValidator;

class UsersController extends ApiController
{

    public function login()
    {
        $validate = $this->validate($_POST, LoginValidator::class);
        if ($validate === true) {
            $user = UsersTable::getByCredentials($_POST['email'], $_POST['password']);
            if ($user) {
                $accessToken = UsersTokenTable::generateToken($user->id());
                return new Response('User logged in successfully', 'logged_in', 200, [
                    'token' => $accessToken,
                    'user'  => $user->toArray(),
                ]);
            }

            return new Response('Email or password is incorrect', 'invalid_login', 400);
        }

        return new Response('Email or password is incorrect', 'invalid_login', 400, $validate);
    }

    public function show($id)
    {
        if (($user_token = $this->isLogged()) != false) {
            if ($user_token->user()->id() == $id || $user_token->user()->role() == 'admin') {
                $user = UsersTable::get($id);
                if ($user) {
                    return new Response('User found', 'user_found', 200, $user->toArray());
                }

                return new Response('User not found', 'user_not_found', 404, null);
            }

        }

        return new Response('Unauthorized', 'unauthorized', 401);

    }

    public function list()
    {
        if (($user_token = $this->isLogged()) != false) {
            if ($user_token->user()->role() == 'admin') {
                $page = intval($_GET['page'] ?? 1);
                if ($page < 1) $page = 1;
                $count = UsersTable::count();
                $users = UsersTable::all($page - 1);
                return new Response('Users found', 'users_found', 200, [
                    'total'         => $count,
                    'pages'         => ceil($count / 5),
                    'current_page'  => $page,
                    'total_current' => $users->count(),
                    'users'         => $users->toArray(),
                ]);
            }
        }

        return new Response('Unauthorized', 'unauthorized', 401);

    }

    public function delete($id)
    {
        if (($user_token = $this->isLogged()) != false) {
            if ($user_token->user()->role() == 'admin' || $user_token->user()->id() == $id) {
                if (UsersTable::get($id)) {
                    try {
                        UsersTable::delete($id);
                        return new Response('User deleted successfully', 'deleted', 200);
                    } catch (\Exception $e) {
                        return new Response('Internal server error', 'internal_server_error', 500);
                    }
                }

                return new Response('User not found', 'user_not_found', 404);
            }
        }

        return new Response('Unauthorized', 'unauthorized', 401);
    }

    public function create()
    {
        $validate = $this->validate($_POST, UsersValidator::class);
        if ($validate === true) {
            try {

                if (!UsersTable::getByEmail($_POST['email'])) {
                    $user = UsersTable::create(User::toObject($_POST));
                    return new Response('User created successfully', 'user_created', 201, $user->toArray());
                }
                return new Response('User already exists', 'user_already_exists', 409);

            } catch (\Exception $e) {
                return new Response('Internal server error', 'internal_server_error', 500);
            }

        }

        return new Response('Failed to create user', 'field_validation_error', 422, $validate);
    }

    public function edit($id)
    {

        if (($user_token = $this->isLogged()) != false) {
            if ($user_token->user()->id() == $id || $user_token->user()->role() == 'admin') {
                $user = UsersTable::get($id);
                if ($user) {
                    $_PUT = [];
                    parse_str(file_get_contents('php://input'), $_PUT);
                    $validate = $this->validate($_PUT, UsersEditValidator::class);
                    if ($validate === true) {
                        try {

                            if (isset($_PUT['name']) && !empty($_PUT['name'])) {
                                $user->setName($_PUT['name']);
                            }

                            if (isset($_PUT['email']) && !empty($_PUT['email'])) {
                                $user->setEmail($_PUT['email']);
                            }

                            if (isset($_PUT['password']) && !empty($_PUT['password'])) {
                                $user->setPassword($_PUT['password']);
                            }

                            if (isset($_PUT['role']) && !empty($_PUT['role'])) {
                                if ($user_token->user()->role() == 'admin') {
                                    $user->setRole($_PUT['role'] == 'admin' ? 'admin' : 'user');
                                } else {
                                    return new Response('Unauthorized', 'unauthorized', 401);
                                }
                            }

                            UsersTable::update($user);
                            return new Response('User updated successfully', 'user_updated', 200, $user->toArray());
                        } catch (\Exception $e) {
                            print_r($e->getMessage());
                            return new Response('Internal server error', 'internal_server_error', 500);
                        }
                    }
                    return new Response('Failed to update user', 'field_validation_error', 422, $validate);
                }

                return new Response('User not found', 'user_not_found', 404);
            }

        }

        return new Response('Unauthorized', 'unauthorized', 401);

    }

    /**
     * @param $id
     * @return Response
     */
    public function drinkPerDay($id)
    {
        if (($user_token = $this->isLogged()) != false) {
            if ($user_token->user()->id() == $id || $user_token->user()->role() == 'admin') {
                $drinks = UsersDrinksTable::drinkPerDay($id);
                return new Response('User drink per day found', 'user_drink_per_day_found', 200, $drinks);
            }
        }
        return new Response('Unauthorized', 'unauthorized', 401);
    }

    /**
     * @return Response
     */
    public function rankingDrinksInDate()
    {
        if (!isset($_GET['date']) || empty($_GET['date']) ||
            !preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $_GET['date'])
        ) {
            return new Response('Invalid date', 'invalid_date', 422);
        }

        if (($user_token = $this->isLogged()) != false) {
            $ranking = UsersDrinksTable::getRankingDrinkersInDate($_GET['date'] ?? date('Y-m-d'));
            return new Response('Ranking found', 'ranking_found', 200, $ranking);

        }
        return new Response('Unauthorized', 'unauthorized', 401);
    }

    /**
     * @param $period
     * @return Response
     */
    public function rankingDrinks($period)
    {
        if (($user_token = $this->isLogged()) != false) {
            if (is_numeric($period)) {
                $ranking = UsersDrinksTable::getRankingDrinkersInPeriod($period);
                return new Response('Ranking found', 'ranking_found', 200, $ranking);
            }
            return new Response('Invalid period', 'invalid_period', 422);
        }

        return new Response('Unauthorized', 'unauthorized', 401);
    }

    /**
     * @param $id
     * @return Response
     */
    public function drink($id)
    {
        if (($user_token = $this->isLogged()) != false) {
            if ($user_token->user()->id() == $id || $user_token->user()->role() == 'admin') {
                $user = UsersTable::get($id);
                if ($user) {
                    $validator = $this->validate($_POST, DrinksValidator::class);
                    if ($validator === true) {
                        try {
                            UsersDrinksTable::drink($user, intval($_POST['drink'] ?? 1));
                            return new Response('User drink updated successfully', 'user_drink_updated', 200, $user->toArray());
                        } catch (\Exception $e) {
                            return new Response('Internal server error', 'internal_server_error', 500);
                        }
                    } else {
                        return new Response('Failed to update user drink', 'field_validation_error', 422, $validator);
                    }

                }
                return new Response('User not found', 'user_not_found', 404);
            }
        }

        return new Response('Unauthorized', 'unauthorized', 401);
    }
}