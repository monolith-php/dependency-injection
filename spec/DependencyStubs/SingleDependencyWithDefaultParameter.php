<?php namespace spec\Monolith\DependencyInjection\DependencyStubs;

final class SingleDependencyWithDefaultParameter
{
    public function __construct(int $number = 0) {}
}