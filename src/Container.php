<?php namespace Monolith\DependencyInjection;

use Psr\Container\ContainerInterface;
use Monolith\Collections\MutableDictionary;

final class Container implements ContainerInterface
{
    private MutableDictionary $resolvers;

    public function __construct()
    {
        $this->resolvers = new MutableDictionary;

        $this->bind(
            Container::class,
            function ($r) {
                return $this;
            }
        );
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
            $this->addResolver(
                $name,
                new Singleton(
                    new ReflectionBasedDependencyResolution($this, $name)
                )
            );
            return;
        }

        // name and target differ so allow this to be deferred
        $this->addResolver(
            $name,
            new Singleton(
                $this->resolverFor($target)
            )
        );
    }

    /**
     * has() determines whether or not a binding exists for the key $name
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return $this->resolvers->has($name);
    }

    /**
     * get() resolves the object for key $name
     *
     * @param string $name
     * @return object
     * @throws CanNotResolveAnUnboundInterface
     */
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

    /**
     * Syntactic sugar for get()
     *
     * @param $name
     * @return mixed|object
     * @throws CanNotResolveAnUnboundInterface
     */
    public function __invoke($name)
    {
        return $this->get($name);
    }

    /**
     * Returns an array listing of bindings.
     *
     * @return array
     */
    public function listBindings(): array
    {
        return array_map(
            function ($resolver) {
                return get_class($resolver);
            }, $this->resolvers->toArray()
        );
    }

    /**
     * Generate a function that returns its own argument.
     * @return callable
     */
    private function identityFunction(): callable
    {
        return fn($instance) => $instance;
    }

    /**
     * Add a resolver to the container's registry.
     *
     * @param string $name
     * @param TargetResolutionAlgorithm $resolver
     * @throws CanNotRebindTheSameName
     */
    private function addResolver(string $name, TargetResolutionAlgorithm $resolver): void
    {
        if ($this->resolvers->has($name)) {
            throw new CanNotRebindTheSameName($name);
        }
        $this->resolvers->add($name, $resolver);
    }

    /**
     * Find and return a resolver for the target type.
     *
     * @param $target
     * @return Callback|InstanceCallback|TargetReference
     * @throws ContainerResolutionTargetNotSupported
     */
    private function resolverFor($target): Callback|InstanceCallback|TargetReference
    {
        if (is_callable($target)) {
            return new Callback($this, $target);
        }

        if (is_object($target)) {
            return new InstanceCallback(
                $this->identityFunction(),
                fn() => $target
            );
        }

        if ( ! is_string($target)) {
            throw new ContainerResolutionTargetNotSupported($target);
        }

        return new TargetReference($this, $target);
    }
}