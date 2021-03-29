<?php

namespace App;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Finder\Finder;
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

    protected function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $this->buildDoctrineMapping($container);
    }

    private function buildDoctrineMapping(ContainerBuilder $container): void
    {
        if (!\class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
            return;
        }

        $finder   = (new Finder())->directories()->in(__DIR__)->depth('== 0');
        $mappings = [];

        /** @var \SplFileInfo $directory */
        foreach ($finder as $directory) {
            $moduleName = $directory->getBasename();
            $realPath   = \realpath(__DIR__ . '/' . $moduleName . '/Infrastructure/Doctrine/Mapping');
            if (false !== $realPath) {
                $mappings[$realPath] = 'App\\' . $moduleName;
            }
        }

        $mappingCompilerPass = DoctrineOrmMappingsPass::createXmlMappingDriver($mappings);
        $container->addCompilerPass($mappingCompilerPass);
    }
}
