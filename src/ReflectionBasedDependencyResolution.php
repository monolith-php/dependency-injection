<?php namespace Monolith\DependencyInjection;

use Monolith\Collections\Collection;

final class ReflectionBasedDependencyResolution implements TargetResolutionAlgorithm
{
    public function __construct(
        private Container $container,
        private string $target
    ) {
    }

    public function resolve()
    {
        // reflect on the target class
        $reflect = new \ReflectionClass($this->target);

        // if the constructor is empty, just resolve it
        $constructor = $reflect->getConstructor();
        if ( ! $constructor) {
            return new $this->target;
        }

        // object resolution
        $parameters = new Collection($constructor->getParameters());

        $parameterInstances = $parameters->map(
            function (\ReflectionParameter $param) {

                $className = ResolveClassTypeOfParameter::getClassType($param);

                if ($className) {
                    return $this->container->get($className);
                }

                if ($param->isDefaultValueAvailable()) {
                    return $param->getDefaultValue();
                }
            }
        );

        // create a new instance of the target with the resolved dependencies
        return $reflect->newInstanceArgs($parameterInstances->toArray());
    }
}