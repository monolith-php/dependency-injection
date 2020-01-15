<?php namespace Monolith\DependencyInjection;

final class Callback implements TargetResolutionAlgorithm
{
    /** @var callable */
    private $callback;
    /** @var Container */
    private $container;

    public function __construct(Container $container, callable $callback)
    {
        $this->callback = $callback;
        $this->container = $container;
    }

    public function resolve()
    {
        return call_user_func($this->callback, $this->container);
    }
}