<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Container;
use Monolith\DependencyInjection\TargetReference;
use PhpSpec\ObjectBehavior;

class TargetReferenceSpec extends ObjectBehavior
{
    /** @var Container */
    private $container;

    function let()
    {
        $this->container = new Container;
        $this->container->bind(SimpleDependency::class, function (Container $c) {
            return new SimpleDependency;
        });
        $this->beConstructedWith($this->container, SimpleDependency::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TargetReference::class);
    }

    function it_can_resolve_a_target_from_the_container_by_name()
    {
        $this->resolve()->shouldHaveType(SimpleDependency::class);
    }
}
