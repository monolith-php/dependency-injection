<?php namespace Monolith\DependencyInjection;

use ReflectionParameter;
use ReflectionUnionType;
use ReflectionNamedType;

final class ResolveClassTypeOfParameter
{
    /**
     * Returns the class name of the parameter type or null.
     * 
     * @param ReflectionParameter $parameter
     * @return string|null
     * @throws CanNotResolveUnionTypesWithoutDefaultValues
     * @throws \ReflectionException
     */
    public static function getClassType(ReflectionParameter $parameter): string|null
    {
        $parameterType = $parameter->getType();

        if ($parameterType instanceof ReflectionUnionType) {
            if ( ! $parameter->isDefaultValueAvailable()) {
                throw new CanNotResolveUnionTypesWithoutDefaultValues("[Function] " . $parameter->getDeclaringFunction()->getName() . " [Argument index] " . $parameter->getPosition() . " [Name] " . $parameter->getName());
            }
            return $parameter->getDefaultValue();
        } elseif ($parameterType instanceof ReflectionNamedType) {
            return $parameterType && ! $parameterType->isBuiltin()
                ? $parameterType->getName()
                : null;
        }

        return null;
    }
}