<?php namespace spec\Monolith\DependencyInjection\DependencyStubs;

final class UnionTypedDependency
{
    public function __construct(TypeOne|TypeTwo $dependency)
    {
    }
}