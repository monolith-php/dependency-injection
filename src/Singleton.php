<?php namespace Monolith\DependencyInjection;

final class Singleton implements TargetResolutionAlgorithm
{
    private object $instance;

    public function __construct(
        private TargetResolutionAlgorithm $target
    ) {
    }

    public function resolve(): object
    {
        if ( ! isset($this->instance)) {
            $this->instance = $this->target->resolve();
        }
        return $this->instance;
    }
}