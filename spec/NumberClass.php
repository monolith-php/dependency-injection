<?php namespace spec\Monolith\DependencyInjection;

final class NumberClass
{
    private $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function number(): int
    {
        return $this->number;
    }
}