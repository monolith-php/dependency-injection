<?php namespace Monolith\DependencyInjection;

use Psr\Container\NotFoundExceptionInterface;

final class CanNotResolveAnUnboundInterface extends DependencyInjectionException implements NotFoundExceptionInterface
{
}