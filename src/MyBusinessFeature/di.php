<?php

declare(strict_types=1);

namespace App\MyBusinessFeature;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $di): void {
    $di->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
        ->set('my_business_feature.some_service', \stdClass::class);
};
