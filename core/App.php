<?php

namespace Core;

use Exception;
use ReflectionClass;

class App
{
    private static $instance;

    public array $instances = [];

    /**
     *  Get the globally available instance (Singleton Instance)
     *
     * @return static
     */
    public static function instance(): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function set($abstract, $concrete = NULL)
    {
        if ($concrete === NULL) {
            $concrete = $abstract;
        }


        $this->instances[$abstract] = $concrete;
    }

    /**
     * Get or register if not available
     * @param string $abstract
     * @param array|null $parameters
     *
     * @return mixed|null|object
     * @throws ReflectionException
     */
    public function get($abstract, ?array $parameters = [])
    {
        if (!isset($this->instances[$abstract])) {
            $this->set($abstract);
        }

        if(is_object($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        return $this->resolve($this->instances[$abstract], $parameters);
    }

    public function resolve($concrete, ?array $parameters = []): mixed
    {
        if(is_array($concrete)) {
            return $concrete;
        }

        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$concrete} is not instantiable");
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * get all dependencies resolved
     *
     * @param $parameters
     *
     * @return array
     * @throws Exception
     */
    public function getDependencies($parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType()->getName();

            if ($dependency) {
                $dependencies[] = $this->get($dependency);
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new Exception("Can not resolve class dependency {$parameter->name}");
            }
        }

        return $dependencies;
    }
}