<?php namespace Monolith\DependencyInjection;

use Closure;

final class InstanceCallback implements TargetResolutionAlgorithm
{
    public function __construct(
        private Closure $instanceCallback,
        private Closure $callback
    ) {
    }

    public function resolve()
    {
        return call_user_func($this->callback, $this->instanceCallback);
    }
}