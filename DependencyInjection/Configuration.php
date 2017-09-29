<?php

/*
 * This file is part of the SeferovAwsBundle package.
 *
 * (c) Farhad Safarov <https://farhadsafarov.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seferov\AwsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('seferov_aws');

        $rootNode
            ->children()
                ->arrayNode('credentials')
                    ->children()
                        ->scalarNode('key')
                            ->defaultValue(null)
                        ->end()
                        ->scalarNode('secret')
                            ->defaultValue(null)
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('profile')
                    ->defaultValue(null)
                ->end()
                ->scalarNode('region')
                    ->defaultValue(null)
                ->end()
                ->arrayNode('services')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('credentials')
                                ->children()
                                    ->scalarNode('key')->end()
                                    ->scalarNode('secret')->end()
                                ->end()
                            ->end()
                            ->scalarNode('region')->end()
                            ->scalarNode('profile')->end()
                            ->scalarNode('endpoint')->end()
                            ->scalarNode('version')->defaultValue('latest')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
