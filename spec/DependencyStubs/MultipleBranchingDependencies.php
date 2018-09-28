<?php namespace spec\Monolith\DependencyInjection\DependencyStubs;

final class MultipleBranchingDependencies
{
    public function __construct(SingleDependency $singleDependency, MultipleDependencies $multipleDependencies) {}
}