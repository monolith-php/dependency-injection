<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Container;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\DependencyStubs\MultipleBranchingDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\MultipleDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\NoDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\SingleDependency;

class ReflectionBasedDependencyResolutionSpec extends ObjectBehavior
{
    /** @var collable */
    private $resolutionCallback;

    function let()
    {
        $this->resolutionCallback = (new Container)->resolutionCallback();
    }

    function it_can_resolve_with_no_dependencies() {
        $this->beConstructedWith($this->resolutionCallback, NoDependencies::class);
        $this->resolve()->shouldHaveType(NoDependencies::class);
    }

    function it_can_resolve_with_a_single_dependency() {
        $this->beConstructedWith($this->resolutionCallback, SingleDependency::class);
        $this->resolve()->shouldHaveType(SingleDependency::class);
    }

    function it_can_resolve_with_multiple_dependencies() {
        $this->beConstructedWith($this->resolutionCallback, MultipleDependencies::class);
        $this->resolve()->shouldHaveType(MultipleDependencies::class);
    }

    function it_can_resolve_multiple_branching_dependencies() {
        $this->beConstructedWith($this->resolutionCallback, MultipleBranchingDependencies::class);
        $this->resolve()->shouldHaveType(MultipleBranchingDependencies::class);
    }
}
