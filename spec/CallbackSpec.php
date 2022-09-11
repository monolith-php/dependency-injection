<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Callback;
use Monolith\DependencyInjection\Container;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\DependencyStubs\NoDependencies;

class CallbackSpec extends ObjectBehavior
{
    private Container $container;

    function let()
    {
        $this->container = new Container;

        $this->beConstructedWith(
            $this->container,
            function ($container) {
                return new NoDependencies;
            }
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Callback::class);
    }

    function it_can_resolve_from_a_callback()
    {
        $this->resolve()->shouldHaveType(NoDependencies::class);
    }
}
