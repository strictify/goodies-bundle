<?php

declare(strict_types=1);

namespace Strictify\Goodies\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /** @noinspection NullPointerExceptionInspection */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('strictify_goodies');
        $root = $treeBuilder->getRootNode();

        $root
            ->children()
                ->arrayNode('pass_thru')
                    ->children()
                        ->scalarNode('keyword')->end()
                        ->arrayNode('query_data')
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

