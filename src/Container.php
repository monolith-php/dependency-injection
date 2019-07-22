<?php namespace Monolith\DependencyInjection;

use Monolith\Collections\MutableDictionary;
use Psr\Container\ContainerInterface;

final class Container implements ContainerInterface
{
    private $resolvers;

    public function __construct()
    {
        $this->resolvers = new MutableDictionary;
        $this->bind(Container::class, function ($r) {
            return $this;
        });
    }

    public function bind(string $name, $target): void
    {
        if ($name === $target) {
            throw new MayNotBindTargetToSelf("Attempted to bind {$name} to {$target}.");
        }

        $this->addResolver($name, $this->resolverFor($target));
    }

    public function singleton(string $name, $target = null)
    {
        if ($name === $target) {
            throw new MayNotBindTargetToSelf("Attempted to bind {$name} to {$target}.");
        }

        // if no target is specified, just resolve self as a singleton target using the
        // reflection based resolution algorithm
        if (is_null($target)) {
            $this->addResolver($name, new Singleton(
                new ReflectionBasedDependencyResolution($this, $name)
            ));
            return;
        }

        // name and target differ so allow this to be deferred
        $this->addResolver($name, new Singleton(
            $this->resolverFor($target)
        ));
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

        return (new ReflectionBasedDependencyResolution($this, $name))->resolve();
    }

    public function resolutionCallback(): callable
    {
        $container = $this;
        return function (string $resolutionTarget) use ($container) {
            return $container->get($resolutionTarget);
        };
    }

    public function instanceCallback(): callable
    {
        return function ($instance) {
            return $instance;
        };
    }

    public function listBindings()
    {
        return array_map(function ($resolver) {
            return get_class($resolver);
        }, $this->resolvers->toArray());
    }

    private function addResolver(string $name, TargetResolutionAlgorithm $resolver)
    {
        if ($this->resolvers->has($name)) {
            throw new CanNotRebindTheSameName($name);
        }
        $this->resolvers->add($name, $resolver);
    }

    private function resolverFor($target)
    {
        if (is_callable($target)) {
            return new Callback($this->resolutionCallback(), $target);
        }

        if (is_object($target)) {
            return new Callback($this->instanceCallback(), function() use ($target) { return $target; });
        }

        if ( ! is_string($target)) {
            throw new ContainerResolutionTargetNotSupported($target);
        }

        return new TargetReference($this->resolutionCallback(), $target);
    }
}