<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Callback;
use Monolith\DependencyInjection\Container;
use PhpSpec\ObjectBehavior;

class CallbackSpec extends ObjectBehavior
{
    /** @var Container */
    private $container;

    function let()
    {
        $this->container = new Container;

        $this->beConstructedWith(
            function (string $resolutionTarget) {
                return $this->container->get($resolutionTarget);
            },
            function ($r) {
                return new SimpleDependency;
            });
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Callback::class);
    }

    function it_can_resolve_from_a_callback()
    {
        $this->resolve()->shouldHaveType(SimpleDependency::class);
    }
}
