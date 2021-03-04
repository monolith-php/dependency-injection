<?php namespace Monolith\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;

final class CanNotRebindTheSameName extends DependencyInjectionException implements ContainerExceptionInterface {}