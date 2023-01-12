<?php

namespace Core;

class Request
{
    private array $parameters = [];

    public function captureParameters(): array
    {
        return $this->parameters = $_REQUEST;
    }

    public function getParameters(): array
    {
        return count($this->parameters) ? $this->parameters : $this->captureParameters();
    }

    public function get($parameterName): array|string|null
    {
        return $this->parameters[$parameterName] ?? null;
    }
}