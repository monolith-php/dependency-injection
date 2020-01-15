<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Callback;
use Monolith\DependencyInjection\Container;
use Monolith\DependencyInjection\Singleton;
use PhpSpec\ObjectBehavior;

class SingletonSpec extends ObjectBehavior
{
    /** @var Container */
    private $container;
    private $resolutionCount;

    function let()
    {
        $this->container = new Container;
        $this->resolutionCount = new NumberObject(0);

        $this->beConstructedWith(
            new Callback($this->container, $this->callback())
        );
    }

    function callback() {
        return function ($c) {
            $this->resolutionCount->setNumber($this->resolutionCount->number()+1);
            return new NumberClass($this->resolutionCount->number());
        };
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Singleton::class);
    }

    function it_can_resolve_the_same_instance_repeatedly()
    {
        expect($this->resolutionCount->number())->shouldBe(0);

        $this->resolve()->number()->shouldBe(1);
        expect($this->resolutionCount->number())->shouldBe(1);

        $this->resolve()->number()->shouldBe(1);
        expect($this->resolutionCount->number())->shouldBe(1);
    }
}
