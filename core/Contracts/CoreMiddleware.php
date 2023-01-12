<?php

namespace Core\Contracts;

interface CoreMiddleware
{
    public function handle(?string $request = null);
}