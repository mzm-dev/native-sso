<?php

namespace Mzm\PhpSso\Http;

use Mzm\PhpSso\Helpers\Logger;

class Router
{
    protected $routes = [];

    public function get($uri, $callback)
    {
        $this->routes['GET'][$this->trim($uri)] = $callback;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
        } else {
            Logger::log("Route : 404 - Page not found.");
            http_response_code(404);
            echo "404 - Page not found.";
        }
    }

    protected function trim($uri)
    {
        return trim($uri, '/');
    }
}
