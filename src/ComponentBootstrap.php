<?php namespace Monolith\DependencyInjection;

interface ComponentBootstrap {
    public function bind(Container $container): void;
    public function start(Container $container): void;
}