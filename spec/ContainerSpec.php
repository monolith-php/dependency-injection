<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Container;
use PhpSpec\ObjectBehavior;

class ContainerSpec extends ObjectBehavior {

    function it_is_initializable() {
        $this->shouldHaveType(Container::class);
    }
}
