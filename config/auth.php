<?php

use App\Env;

return [
    'username' => Env::get('USER_NAME', 'admin'),
    'password' => Env::get('USER_PASSWORD', 'admin'),
];