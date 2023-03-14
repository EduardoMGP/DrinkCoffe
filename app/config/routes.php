<?php

use App\Controllers\UsersController;
use Mosyle\Routers;

Routers::get('/api/users/{id}', UsersController::class, 'show');
Routers::get('/api/users', UsersController::class, 'list');

Routers::put('/api/users/{id}', UsersController::class, 'edit');
Routers::delete('/api/users/{id}', UsersController::class, 'delete');

Routers::post('/api/users', UsersController::class, 'create');
Routers::post('/api/login', UsersController::class, 'login');
Routers::post('/api/users/{id}/drink', UsersController::class, 'drink');

