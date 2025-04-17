<?php

declare(strict_types=1);

namespace Strictify\Goodies\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Strictify\Goodies\Goodies\FiltersPassThru\RouterDecorator;

class StrictifyGoodiesExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        /** @var array{pass_thru: array{keyword: string, query_data: array<string>}} $config */
        $config = $this->processConfiguration($configuration, $configs);
//        $definition = $container->getDefinition(RouterDecorator::class);
//        $definition->setArgument(0, $config['pass_thru']['keyword']);
//        $definition->setArgument(1, $config['pass_thru']['query_data']);
    }
}
