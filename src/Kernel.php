<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.yaml');
        $container->import("../config/{packages}/{$this->environment}/*.yaml");
        $container->import('./**/{di}.php');
        $container->import("./**/{di}_{$this->environment}.php");
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import("../config/{routes}/{$this->environment}/*.yaml");
        $routes->import('../config/{routes}/*.yaml');
        $routes->import("./**/{routing}_{$this->environment}.php");
        $routes->import('./**/{routing}.php');
    }
}
