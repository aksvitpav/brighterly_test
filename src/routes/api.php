<?php

use App\Controllers\UserController;

return [
    'GET' => [
        '/users' => [UserController::class, 'getAllUsers'],
        '/users/{id}' => [UserController::class, 'getUserById'],
    ],
];
