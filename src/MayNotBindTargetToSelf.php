<?php namespace Monolith\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;

final class MayNotBindTargetToSelf extends DependencyInjectionException implements ContainerExceptionInterface {}