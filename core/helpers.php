<?php

use Core\App;
use Core\Request;

if(! function_exists('env')) {
    function env(string $key, string $default = null): string|null
    {
        return $_ENV[$key] ?? $default;
    }
}

if(! function_exists('dd')) {
    function dd(...$values): void
    {
        foreach ($values as $value) {
            echo "<pre>";
            var_dump($value);
            echo "</pre>";
        }

        die();
    }
}

if(! function_exists('abort')) {
    function abort(?int $statusCode, ?string $message): string
    {
        http_response_code($statusCode);

        die($message);
    }
}

if(! function_exists('base_path')) {
    function base_path($path): string
    {
        return BASE_PATH. $path;
    }
}

if(! function_exists('view')) {
    function view($viewName, ?array $parameters = [])
    {
        extract($parameters);

        require base_path('/resources/views/'.$viewName.'.view.php');
    }
}

if(! function_exists('request')) {
    function request(?string $parameterName = null): mixed
    {
        $app = App::instance();
        return $parameterName ? $app->instances[Request::class]->get($parameterName) : $app->instances[Request::class];
    }
}

if(! function_exists('redirectTo')) {
    function redirectTo($location)
    {
        header("location: {$location}");
    }
}