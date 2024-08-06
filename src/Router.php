<?php

namespace App;

use App\Controllers\AuthController;
use App\Response\ErrorResponse;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->initializeRoutes();
    }

    private function initializeRoutes(): void
    {
        $this->routes = include __DIR__ . '/../src/routes/api.php';
    }

    public function handleRequest(): void
    {
        $authController = new AuthController();
        $authController->authenticate();

        $requestUri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $route = $this->matchRoute($requestUri, $method);

        if ($route) {
            [$controllerClass, $methodName, $params] = $route;
            $controller = new $controllerClass();
            call_user_func_array([$controller, $methodName], $params);
        } else {
            $response = new ErrorResponse('Page not found', 404);
            $response->send();
        }
    }

    private function matchRoute(string $uri, string $method): ?array
    {
        // Remove the leading and trailing slashes from the URI and split it into parts.
        $uriParts = array_filter(explode('/', trim(parse_url($uri, PHP_URL_PATH), '/')));

        // Check whether the method is supported
        if (! isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $pattern => $action) {
            // Divide the route template into parts.
            $patternParts = array_filter(explode('/', trim($pattern, '/')));

            // If the amount parts does not match, skip this route.
            if (count($uriParts) !== count($patternParts)) {
                continue;
            }

            // Check whether the parts of the route, and the template match.
            $params = [];
            $isMatch = true;
            foreach ($patternParts as $i => $part) {
                if (str_starts_with($part, '{') && strpos($part, '}') === (strlen($part) - 1)) {
                    // This is a route parameter
                    $params[] = $uriParts[$i];
                } elseif ($part !== $uriParts[$i]) {
                    // Part of the pattern does not match
                    $isMatch = false;
                    break;
                }
            }

            if ($isMatch) {
                // Return the action with parameters
                return [$action[0], $action[1], $params];
            }
        }

        return null;
    }
}