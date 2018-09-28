<?php namespace Monolith\DependencyInjection;

use Monolith\Collections\Collection;

final class ReflectionBasedDependencyResolution implements TargetResolutionAlgorithm
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
        // reflect on the target class
        $reflect = new \ReflectionClass($this->target);

        // if the constructor is empty, just resolve it
        $constructor = $reflect->getConstructor();
        if ( ! $constructor) {
            return ($this->resolutionCallback)($this->target);
        }

        // get the types for each constructor parameter
        $parameterClasses = (new Collection(
            $constructor->getParameters()
        ))
            ->map(function (\ReflectionParameter $parameter) {
                return $parameter->getClass() ? $parameter->getClass()->name : null;
            })->filter(function ($class) {
                return ! is_null($class);
            });

        if ($parameterClasses->count() != count($constructor->getParameters())) {
            throw new CanNotReflectivelyResolveTargetWithConstructorPrimitives($this->target);
        }

        // resolve each parameter independently into arguments
        $arguments = $parameterClasses->map(function (string $className) {
            return ($this->resolutionCallback)($className);
        });

        // create a new instance of the target with the resolved dependencies
        return $reflect->newInstanceArgs($arguments->toArray());
    }
}