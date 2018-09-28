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
        if ($name === $target) {
            throw new MayNotBindTargetToSelf("Attempted to bind {$name} to {$target}.");
        }

        $this->resolvers->add(
            $name, $this->resolverFor($target)
        );
    }

    public function singleton(string $name, $target = null)
    {
        if ($name === $target) {
            throw new MayNotBindTargetToSelf("Attempted to bind {$name} to {$target}.");
        }

        // if no target is specified, just resolve self as a singleton target using the
        // reflection based resolution algorithm
        if (is_null($target)) {
            $this->resolvers->add(
                $name,
                new Singleton(
                    new ReflectionBasedDependencyResolution($this->resolutionCallback(), $name)
                )
            );
            return;
        }

        // name and target differ so allow this to be deferred
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
            return new Callback($this->resolutionCallback(), $target);
        }

        if ( ! is_string($target)) {
            throw new ContainerResolutionTargetNotSupported($target);
        }

        return new TargetReference($this->resolutionCallback(), $target);
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

        if (interface_exists($name) && ! $this->resolvers->has($name)) {
            throw new CanNotResolveAnUnboundInterface($name);
        }

        return (new ReflectionBasedDependencyResolution($this->resolutionCallback(), $name))->resolve();
    }

    public function resolutionCallback(): callable
    {
        $container = $this;
        return function (string $resolutionTarget) use ($container) {
            return $container->get($resolutionTarget);
        };
    }
}
