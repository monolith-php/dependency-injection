<?php namespace spec\Monolith\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Monolith\DependencyInjection\Container;
use spec\Monolith\DependencyInjection\DependencyStubs\NoDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\SingleDependency;
use spec\Monolith\DependencyInjection\DependencyStubs\MultipleDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\UnionTypedDependency;
use Monolith\DependencyInjection\CanNotResolveUnionTypesWithoutDefaultValues;
use spec\Monolith\DependencyInjection\DependencyStubs\MultipleBranchingDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\UnionTypedDependencyWithDefaultParameter;

class ReflectionBasedDependencyResolutionSpec extends ObjectBehavior
{
    private Container $container;

    function let()
    {
        $this->container = new Container;
    }

    function it_can_resolve_with_no_dependencies()
    {
        $this->beConstructedWith($this->container, NoDependencies::class);
        $this->resolve()->shouldHaveType(NoDependencies::class);
    }

    function it_can_resolve_with_a_single_dependency()
    {
        $this->beConstructedWith($this->container, SingleDependency::class);
        $this->resolve()->shouldHaveType(SingleDependency::class);
    }

    function it_can_resolve_with_multiple_dependencies()
    {
        $this->beConstructedWith($this->container, MultipleDependencies::class);
        $this->resolve()->shouldHaveType(MultipleDependencies::class);
    }

    function it_can_resolve_multiple_branching_dependencies()
    {
        $this->beConstructedWith($this->container, MultipleBranchingDependencies::class);
        $this->resolve()->shouldHaveType(MultipleBranchingDependencies::class);
    }

    function it_can_not_resolve_union_types_without_defaults()
    {
        $this->beConstructedWith($this->container, UnionTypedDependency::class);
        $this->shouldThrow(CanNotResolveUnionTypesWithoutDefaultValues::class)->during('resolve');
    }

    function it_can_resolve_default_values_for_union_types()
    {
        $this->beConstructedWith($this->container, UnionTypedDependencyWithDefaultParameter::class);
        $this->resolve()->shouldHaveType(UnionTypedDependencyWithDefaultParameter::class);
    }
}
