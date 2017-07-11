<?php namespace Monolith\DependencyInjection;

final class Components {
    public static function loadInto(Container $container, array $modules) {
        // First, bind all modules.
        // don't map unless you're mapping
        foreach ($modules as $module) {
            $module->bind($container);
        }

        // Then, when all modules have been bound, start them.
        foreach ($modules as $module) {
            $module->start($container);
        }
    }
}