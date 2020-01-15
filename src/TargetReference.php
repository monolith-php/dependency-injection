<?php namespace Monolith\DependencyInjection;

final class TargetReference implements TargetResolutionAlgorithm
{
    /** @var string */
    private $target;
    /** @var Container */
    private $container;

    public function __construct(Container $container, string $target)
    {
        $this->target = $target;
        $this->container = $container;
    }

    public function resolve()
    {
        return $this->container->get($this->target);
    }
}