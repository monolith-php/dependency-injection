<?php namespace Monolith\DependencyInjection;

final class InstanceCallback implements TargetResolutionAlgorithm
{
    /** @var callable */
    private $callback;
    /** @var callable */
    private $instanceCallback;

    public function __construct(callable $instanceCallback, callable $callback)
    {
        $this->callback = $callback;
        $this->instanceCallback = $instanceCallback;
    }

    public function resolve()
    {
        return call_user_func($this->callback, $this->instanceCallback);
    }
}