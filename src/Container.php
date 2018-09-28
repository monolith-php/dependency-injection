<?php namespace Monolith\DependencyInjection;

use Monolith\Collections\Map;
use Psr\Container\ContainerInterface;

final class Container implements ContainerInterface
{
    private $resolvers;

    public function __construct()
    {
        $this->resolvers = new Map;
    }

    public function bind(string $name, $target): void
    {
        $this->resolvers->add(
            $name, $this->resolverFor($target)
        );
    }

    public function singleton(string $name, $target)
    {
        $this->resolvers->add(
            $name,
            new Singleton(
                $this->resolverFor($target)
            )
        );
    }

    private function resolverFor($target)
    {
        if (is_callable($target)) {
            return new Callback($this, $target);
        }

        if ( ! is_string($target)) {
            throw new ContainerResolutionTargetNotSupported($target);
        }
        return new TargetReference($this, $target);
    }

    public function has($name)
    {
        return $this->resolvers->has($name);
    }

    public function get($name)
    {
        $resolver = $this->resolvers->get($name);

        if ($resolver) {
            return $resolver->resolve();
        }

        return (new ReflectionBasedDependencyResolution($this, $name))->resolve();
    }
}
