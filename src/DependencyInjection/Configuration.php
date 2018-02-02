<?php
namespace Olla\Platform\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;


final class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('olla_platform');
        $rootNode
            ->children()
                ->scalarNode('title')->defaultValue('Olla Platform')->end()
                ->scalarNode('description')->defaultValue('Implemetation of FLOW RAD')->end()
                ->scalarNode('version')->defaultValue('1.0.0')->end()
                ->arrayNode('provider')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('database')->end()
                        ->scalarNode('monitor')->end()
                        ->scalarNode('serializer')->end()
                        ->scalarNode('validator')->end()
                        ->scalarNode('guard')->end()
                        ->scalarNode('gate')->end()
                        ->scalarNode('middleware')->end()
                        ->scalarNode('credential')->end()
                    ->end()
                ->end()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('operation')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('resource')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('admin')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('frontend')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('presentation')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('graphql')
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultFalse()
                                ->end()
                                ->scalarNode('cache_dir')
                                    ->defaultValue('')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('restapi')
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultTrue()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('frontend')
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultFalse()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('admin')
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultFalse()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('swagger')
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultTrue()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('graphiql')
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultTrue()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('class')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('operation')->end()
                        ->scalarNode('item')->end()
                        ->scalarNode('create')->end()
                        ->scalarNode('update')->end()
                        ->scalarNode('delete')->end()
                    ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}