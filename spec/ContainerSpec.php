<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\Container;
use PhpSpec\ObjectBehavior;

class ContainerSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(Container::class);
    }

//    function it_can_resolve_simple_dependencies_even_when_unbound()
//    {
//        $this->get(SimpleDependency::class)->shouldHaveType(SimpleDependency::class);
//    }
//
//    function it_can_bind_resolution_functions_to_names()
//    {
//        $this->bind(ComplexDependency::class, function () {
//            return new ComplexDependency(new SimpleDependency, new SimpleDependency);
//        });
//        $this->get(ComplexDependency::class)->shouldHaveType(ComplexDependency::class);
//    }
//
//    function it_can_bind_a_resolution_target_to_names()
//    {
//        $this->bind(SimpleDependencyAbstraction::class, SimpleDependency::class);
//        $this->get(SimpleDependencyAbstraction::class)->shouldHaveType(SimpleDependency::class);
//    }
//
//    function it_can_resolve_new_instances_on_resolution()
//    {
//        $this->bind(SimpleDependency::class, SimpleDependency::class);
//
//        $dependency1 = $this->get(SimpleDependency::class);
//        $dependency2 = $this->get(SimpleDependency::class);
//
//        $dependency1->shouldNotBe($dependency2);
//    }
//
//    function it_can_resolve_a_singleton_instance()
//    {
//        $this->singleton(SimpleDependency::class);
//
//        $dependency1 = $this->get(SimpleDependency::class);
//        $dependency2 = $this->get(SimpleDependency::class);
//
//        $dependency1->shouldBe($dependency2);
//    }
}
