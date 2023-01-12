<?php

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