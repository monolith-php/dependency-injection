<?php namespace Monolith\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;

final class CanNotUnsetBindingThroughArrayAccess extends DependencyInjectionException implements ContainerExceptionInterface {}