<?php

namespace Core;

use Exception;
use ReflectionClass;

class App
{
    private static $instance;

    public array $instances = [];

    protected array $arrays = [];

    /**
     *  Get the globally available instance
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

    public function setArray($key, $value = null): void
    {
        $this->arrays[$key] = $value;
    }

    /**
     * @throws \Exception
     */
    public function getArray($key): mixed
    {
        return array_key_exists($key, $this->arrays) ?
            $this->arrays[$key] :
            throw new \Exception('Sorry, given key is not available.');
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

    /**
     * resolve single
     *
     * @param string $concrete
     * @param array|null $parameters
     *
     * @return mixed|object
     * @throws \ReflectionException
     */
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