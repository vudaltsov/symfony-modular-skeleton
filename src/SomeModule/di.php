<?php

declare(strict_types=1);

namespace App\SomeModule;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $di): void {
    $services = $di->services();

    $services->set('some_module.test_service', \stdClass::class);
};
