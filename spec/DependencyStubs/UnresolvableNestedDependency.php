<?php namespace spec\Monolith\DependencyInjection\DependencyStubs;

use spec\Monolith\DependencyInjection\NumberClass;
use spec\Monolith\DependencyInjection\SimpleDependency;

final class UnresolvableNestedDependency
{
    /** @var NumberClass */
    private $number;

    public function __construct(NumberClass $number, NoDependencies $noDependencies)
    {
        $this->number = $number;
    }

    public function number(): NumberClass
    {
        return $this->number;
    }
}