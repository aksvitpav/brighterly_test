<?php

namespace App;

class Config
{
    private static ?Config $instance = null;
    private array $config = [];

    private function __construct()
    {
        $this->loadDirectoryConfig();
    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    private function loadDirectoryConfig(): void
    {
        foreach (glob(__DIR__ . '/../config/*.php') as $file) {
            $this->config[basename($file, '.php')] = require $file;
        }
    }

    public function get($key): mixed
    {
        $keys = explode('.', $key);
        $config = $this->config;

        foreach ($keys as $key) {
            if (isset($config[$key])) {
                $config = $config[$key];
            } else {
                return null;
            }
        }

        return $config;
    }
}