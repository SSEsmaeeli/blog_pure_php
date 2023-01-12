<?php

namespace Core;

class Session
{
    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function has($key): bool
    {
        return ! is_null($this->get($key));
    }

    public function forget($key): void
    {
        unset($_SESSION[$key]);
    }
}