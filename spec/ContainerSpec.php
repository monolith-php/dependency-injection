<?php namespace spec\Monolith\DependencyInjection;

use Monolith\DependencyInjection\CanNotRebindTheSameName;
use Monolith\DependencyInjection\CanNotResolveAnUnboundInterface;
use Monolith\DependencyInjection\Container;
use Monolith\DependencyInjection\MayNotBindTargetToSelf;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\DependencyStubs\NoDependencies;
use spec\Monolith\DependencyInjection\DependencyStubs\NoDependenciesInterface;
use spec\Monolith\DependencyInjection\DependencyStubs\UnresolvableNestedDependency;

class ContainerSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(Container::class);
    }

    function it_can_resolve_unbound_objects_based_on_class_name()
    {
        $this->get(NoDependencies::class)->shouldHaveType(NoDependencies::class);
    }

    function it_can_bind_resolution_functions_to_names()
    {
        $this->bind(UnresolvableNestedDependency::class, function () {
            return new UnresolvableNestedDependency(new NumberClass(2), new NoDependencies);
        });
        $this->get(UnresolvableNestedDependency::class)->shouldHaveType(UnresolvableNestedDependency::class);
    }

    function it_can_bind_a_resolution_target_to_names()
    {
        $this->bind(NoDependenciesInterface::class, NoDependencies::class);
        $this->get(NoDependenciesInterface::class)->shouldHaveType(NoDependencies::class);
    }

    function it_will_not_allow_you_to_bind_a_target_to_itself()
    {
        $this->shouldThrow(MayNotBindTargetToSelf::class)->during('bind', [NoDependencies::class, NoDependencies::class]);
    }

    function it_can_resolve_new_object_instances_on_resolution_of_a_target()
    {
        $dependency1 = $this->get(NoDependencies::class);
        $dependency2 = $this->get(NoDependencies::class);

        $dependency1->shouldNotBe($dependency2);
    }

    function it_can_resolve_a_singleton_instance()
    {
        $this->singleton(NoDependencies::class);

        $dependency1 = $this->get(NoDependencies::class);
        $dependency2 = $this->get(NoDependencies::class);

        $dependency1->shouldBe($dependency2);
    }

    function it_throws_when_trying_to_resolve_an_unbound_interface()
    {
        $this->shouldThrow(CanNotResolveAnUnboundInterface::class)->during('get', [NoDependenciesInterface::class]);
    }

    function it_can_bind_a_reference_to_another_binding()
    {
        $this->bind(UnresolvableNestedDependency::class, function ($r) {
            return new UnresolvableNestedDependency(new NumberClass(23), new NoDependencies());
        });

        $this->get(UnresolvableNestedDependency::class)->number()->number()->shouldBe(23);

        $this->bind('arbitrary name', UnresolvableNestedDependency::class);

        $this->get('arbitrary name')->shouldHaveType(UnresolvableNestedDependency::class);
    }

    function it_can_bind_a_singleton_reference_to_another_binding()
    {
        $this->bind(UnresolvableNestedDependency::class, function ($r) {
            return new UnresolvableNestedDependency(new NumberClass(23), new NoDependencies());
        });

        $this->get(UnresolvableNestedDependency::class)->number()->number()->shouldBe(23);

        $this->singleton('arbitrary name', UnresolvableNestedDependency::class);

        $this->get('arbitrary name')->shouldHaveType(UnresolvableNestedDependency::class);
    }

    function it_can_not_rebind_the_same_name()
    {
        $this->bind(UnresolvableNestedDependency::class, function ($r) {
            return new UnresolvableNestedDependency(new NumberClass(rand(0, 999)), new NoDependencies());
        });
        $this->shouldThrow(CanNotRebindTheSameName::class)->during('singleton', [UnresolvableNestedDependency::class]);
    }

    function it_can_resolve_hde_instance_of_itself()
    {
        $this->get(Container::class)->shouldHaveType(Container::class);
    }
}
