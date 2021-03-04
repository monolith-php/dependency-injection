<?php namespace Monolith\DependencyInjection;

use Closure;

final class Callback implements TargetResolutionAlgorithm
{
    public function __construct(
        private Container $container,
        private Closure $callback
    ) {
    }

    public function resolve()
    {
        return call_user_func($this->callback, $this->container);
    }
}