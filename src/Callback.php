<?php namespace Monolith\DependencyInjection;

final class Callback implements TargetResolutionAlgorithm
{
    /** @var Container */
    private $container;
    /** @var callable */
    private $callback;

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