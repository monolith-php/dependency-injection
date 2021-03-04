<?php namespace Monolith\DependencyInjection;

final class TargetReference implements TargetResolutionAlgorithm
{
    public function __construct(
        private Container $container,
        private string $target
    ) {
    }

    public function resolve()
    {
        return $this->container->get($this->target);
    }
}