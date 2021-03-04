<?php namespace Monolith\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;

final class CanNotResolveUnionTypesWithoutDefaultValues extends DependencyInjectionException implements ContainerExceptionInterface
{
}