<?php

declare(strict_types=1);

namespace Core;

use ReflectionClass;
use Exception;

class Container
{
    private array $registry = [];
    private array $instances = [];

    public function set(string $name, \Closure $value): void
    {
        $this->registry[$name] = $value;
    }

    public function singleton(string $name, \Closure $value): void
    {
        $this->registry[$name] = function () use ($value, $name) {
            if (!isset($this->instances[$name])) {
                $this->instances[$name] = $value();
            }
            return $this->instances[$name];
        };
    }

    public function get(string $class_name): object
    {
        if (array_key_exists($class_name, $this->registry)) {
            return $this->registry[$class_name]();
        }

        $reflector = new ReflectionClass($class_name);

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $class_name;
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();
            if ($type && ($type instanceof \ReflectionNamedType && !$type->isBuiltin())) {
                $dependencies[] = $this->get((string) $type);
            } else {
                throw new Exception("Cannot resolve parameter '{$parameter->getName()}' for class '{$class_name}'");
            }
        }


        return new $class_name(...$dependencies);
    }
}
