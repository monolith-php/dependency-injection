<?php namespace Monolith\DependencyInjection;

final class TargetReference implements TargetResolutionAlgorithm
{
    /** @var Container */
    private $container;
    /** @var string */
    private $target;

    public function __construct(Container $container, string $target)
    {
        $this->container = $container;
        $this->target = $target;
    }

    public function resolve()
    {
        return $this->container->get($this->target);
    }
}