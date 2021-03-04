<?php namespace Monolith\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;

final class CanNotBindThroughArrayAccess extends DependencyInjectionException implements ContainerExceptionInterface {}