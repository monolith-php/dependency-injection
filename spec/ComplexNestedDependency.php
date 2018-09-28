<?php namespace spec\Monolith\DependencyInjection;

final class ComplexNestedDependency
{
    /** @var NumberClass */
    private $number;
    /** @var ComplexDependency */
    private $complexDependency;

    public function __construct(NumberClass $number, ComplexDependency $complexDependency)
    {
        $this->number = $number;
        $this->complexDependency = $complexDependency;
    }
}