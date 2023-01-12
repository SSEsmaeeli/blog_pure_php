<?php

namespace Core;

use Exception;

class App
{
    public array $instances = [];

    public function set($key, $value = null): void
    {
        $this->instances[$key] = $value;
    }

    /**
     * @throws Exception
     */
    public function get($key): mixed
    {
        return array_key_exists($key, $this->instances) ?
            $this->instances[$key] :
            throw new Exception('Sorry, given key is not available.');
    }
}