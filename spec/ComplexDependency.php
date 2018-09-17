<?php namespace spec\Monolith\DependencyInjection;

class ComplexDependency {

    public function __construct(SimpleDependency $simple1, SimpleDependency $simple2) {
    }
}