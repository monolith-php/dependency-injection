<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Container;
use Monolith\DependencyInjection\TargetReference;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\DependencyStubs\NoDependencies;

class TargetReferenceSpec extends ObjectBehavior
{
    function let()
    {
        $container = new Container;

        $container->bind(NoDependencies::class, function ($c) {
            return new NoDependencies;
        });

        $this->beConstructedWith($container, NoDependencies::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TargetReference::class);
    }

    function it_can_resolve_a_target_from_the_container_by_name()
    {
        $this->resolve()->shouldHaveType(NoDependencies::class);
    }
}
