<?php namespace Monolith\DependencyInjection;

use ArrayAccess;
use Monolith\Collections\Map;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class Container implements ContainerInterface, ArrayAccess {

    private $bindings;

    public function __construct() {
        $this->bindings = new Map;
    }

    public function bind(string $name, $target = null): void {

        // if target is null then we resolve a new self
        if ($target == null) {
            $this->bindings->add($name, $this->resolverFor($name));
            return;
        }

        // if target is callable then it's a resolver
        if (is_callable($target)) {
            $this->bindings->add($name, $target);
            return;
        }

        // if target is not a string, we don't know what's going on
        if ( ! is_string($target)) {
            throw new CanNotBindIncompatibleResolver($target);
        }

        // if target is string (a fqcn) then resolve target
        $this->bindings->add($name, $this->resolverFor($target));
    }

    public function singleton(string $name, $target = null): void {

        // if target is null then we resolve a new self
        if ($target == null) {
            $this->bind($name, new Singleton($this->resolverFor($name), $this));
            return;
        }

        // if target is callable then it's a resolver
        if (is_callable($target)) {
            $this->bind($name, new Singleton($target, $this));
            return;
        }

        // if target is not a string, we don't know what's going on
        if ( ! is_string($target)) {
            throw new CanNotBindIncompatibleResolver($target);
        }

        // if target is string (a fqcn) then resolve target
        $this->bind($name, new Singleton($this->resolverFor($target), $this));
    }

    public function has($name) {
        return $this->bindings->has($name);
    }

    public function get($name) {

        $binding = $this->bindings->get($name);

        if ($binding) {
            return $binding($this);
        }

        return $this->resolverFor($name)($this);
    }

    private function resolverFor(string $className): callable {
        return function() use ($className) {
            return $this->get($className);
        };
    }

    public function offsetExists($offset): bool {
        return array_key_exists($offset, $this->bindings);
    }

    public function offsetGet($offset) {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value): void {
        throw new CanNotBindThroughArrayAccess;
    }

    public function offsetUnset($offset): void {
        throw new CanNotUnsetBindingThroughArrayAccess;
    }
}
