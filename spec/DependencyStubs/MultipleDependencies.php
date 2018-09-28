<?php namespace spec\Monolith\DependencyInjection\DependencyStubs;

final class MultipleDependencies
{
    public function __construct(SingleDependency $singleDependency1, SingleDependency $singleDependency2) {}
}