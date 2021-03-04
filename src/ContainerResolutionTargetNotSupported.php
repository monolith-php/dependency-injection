<?php namespace Monolith\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;

final class ContainerResolutionTargetNotSupported extends DependencyInjectionException implements ContainerExceptionInterface {}