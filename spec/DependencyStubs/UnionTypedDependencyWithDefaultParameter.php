<?php namespace spec\Monolith\DependencyInjection\DependencyStubs;

final class UnionTypedDependencyWithDefaultParameter
{
    public function __construct(TypeOne|TypeTwo|null $dependency = null)
    {
    }
}