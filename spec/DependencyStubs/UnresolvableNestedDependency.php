<?php namespace spec\Monolith\DependencyInjection\DependencyStubs;

use spec\Monolith\DependencyInjection\SimpleDependency;
use spec\Monolith\DependencyInjection\NumberClass;

final class UnresolvableNestedDependency
{
    public function __construct(NumberClass $number, NoDependencies $noDependencies) {}
}