<?php namespace Monolith\DependencyInjection;

use ArrayAccess;
use Monolith\Collections\Map;

final class Container implements ArrayAccess {
    private $bindings;

    public function __construct() {
        $this->bindings = new Map;
    }

    public function bind(string $name, ?callable $resolver = null): void {
        $resolver = $resolver ?: $this->fn($name);
        $this->bindings->add($name, $resolver);
    }

    public function singleton(string $name, ?callable $resolver = null): void {
        if ($this->isBound($name)) {
            throw new ClassWasAlreadyBound($name);
        }
        $resolver = $resolver ?: $this->fn($name);
        $this->bind($name, new Singleton($resolver, $this));
    }

    public function isBound(string $name): bool {
        return $this->bindings->hasKey($name);
    }

    public function resolve(string $name) {
        $f = $this->bindings->get($name);
        if ( ! $f) {
            throw new \Exception("Could not resolve {$name}.");
        }
        return $f($this);
    }

    private function fn(string $className): callable {
        return function() use ($className) {
            return new $className;
        };
    }

    public function offsetExists($offset): bool {
        return $this->isBound($offset);
    }

    public function offsetGet($offset) {
        return $this->resolve($offset);
    }

    public function offsetSet($offset, $value): void {
        throw new CannotBindThroughArrayAccess;
    }

    public function offsetUnset($offset): void {
        throw new CannotUnsetBindingThroughArrayAccess;
    }
}