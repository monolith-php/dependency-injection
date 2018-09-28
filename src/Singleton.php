<?php namespace Monolith\DependencyInjection;

final class Singleton implements TargetResolutionAlgorithm
{
    private $instance;

    /** @var TargetResolutionAlgorithm */
    private $target;

    public function __construct(TargetResolutionAlgorithm $target)
    {
        $this->target = $target;
    }

    public function resolve()
    {
        if ( ! isset($this->instance)) {
            $this->instance = $this->target->resolve();
        }
        return $this->instance;
    }
}