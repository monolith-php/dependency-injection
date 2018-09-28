<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Container;
use Monolith\DependencyInjection\TargetReference;
use PhpSpec\ObjectBehavior;

class TargetReferenceSpec extends ObjectBehavior
{
    /** @var callable */
    private $resolutionCallback;

    function let()
    {
        $container = new Container;

        $this->resolutionCallback = $container->resolutionCallback();

        $container->bind(SimpleDependency::class, function ($c) {
            return new SimpleDependency;
        });

        $this->beConstructedWith($this->resolutionCallback, SimpleDependency::class);
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
