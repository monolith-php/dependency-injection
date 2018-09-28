<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Container;
use Monolith\DependencyInjection\ReflectionBasedDependencyResolution;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\DependencyStubs\MultipleBranchingDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\MultipleDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\NoDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\SingleDependency;

class ReflectionBasedDependencyResolutionSpec extends ObjectBehavior
{
    private $container;

    function let()
    {
        $this->container = new Container;
    }

    function it_can_resolve_with_no_dependencies() {
        $container = new Container;
        $this->beConstructedWith($container, NoDependencies::class);
        $this->resolve()->shouldHaveType(NoDependencies::class);
    }

    function it_can_resolve_with_a_single_dependency() {
        $container = new Container;
        $this->beConstructedWith($container, SingleDependency::class);
        $this->resolve()->shouldHaveType(SingleDependency::class);
    }

    function it_can_resolve_with_multiple_dependencies() {
        $container = new Container;
        $this->beConstructedWith($container, MultipleDependencies::class);
        $this->resolve()->shouldHaveType(MultipleDependencies::class);
    }

    function it_can_resolve_multiple_branching_dependencies() {
        $container = new Container;
        $this->beConstructedWith($container, MultipleBranchingDependencies::class);
        $this->resolve()->shouldHaveType(MultipleBranchingDependencies::class);
    }
}
