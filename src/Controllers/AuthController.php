<?php

namespace App\Controllers;

use App\Config;

class AuthController
{
    public function authenticate(): void
    {
        $config = Config::getInstance();
        $username = $config->get('auth.username');
        $password = $config->get('auth.password');

        if (
            ! isset($_SERVER['PHP_AUTH_USER'])
            || ! isset($_SERVER['PHP_AUTH_PW'])
        ) {
            $this->sendAuthHeaders();
            exit;
        }

        if (
            $_SERVER['PHP_AUTH_USER'] !== $username
            || $_SERVER['PHP_AUTH_PW'] !== $password
        ) {
            $this->sendAuthHeaders();
            exit;
        }
    }

    private function sendAuthHeaders(): void
    {
        header('HTTP/1.0 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="Private Area"');
        echo json_encode(['error' => 'Authentication required']);
    }
}