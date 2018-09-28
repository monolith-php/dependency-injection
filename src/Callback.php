<?php namespace Monolith\DependencyInjection;

final class Callback implements TargetResolutionAlgorithm
{
    /** @var callable */
    private $resolutionCallback;
    /** @var callable */
    private $callback;

    public function __construct(callable $resolutionCallback, callable $callback)
    {
        $this->callback = $callback;
        $this->resolutionCallback = $resolutionCallback;
    }

    public function resolve()
    {
        return call_user_func($this->callback, $this->resolutionCallback);
    }
}