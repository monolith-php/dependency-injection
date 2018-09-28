<?php namespace Monolith\DependencyInjection;

final class TargetReference implements TargetResolutionAlgorithm
{
    /** @var callable */
    private $resolutionCallback;
    /** @var string */
    private $target;

    public function __construct(callable $resolutionCallback, string $target)
    {
        $this->resolutionCallback = $resolutionCallback;
        $this->target = $target;
    }

    public function resolve()
    {
        return ($this->resolutionCallback)($this->target);
    }
}