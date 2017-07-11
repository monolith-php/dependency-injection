<?php namespace Monolith\DependencyInjection;

class ClassWasAlreadyBound extends \Exception {
    public function __construct(string $className) {
        parent::__construct("Class was already bound [{$className}] with container.");
    }
}