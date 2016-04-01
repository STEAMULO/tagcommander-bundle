<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * 
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('meup_tagcommander');

        $rootNode
            ->children()

                ->scalarNode('default_event')
                    ->defaultValue('default')
                ->end()

                ->arrayNode('datalayer')
                    ->children()
                        ->scalarNode('name')
                            ->defaultValue('tc_vars')
                        ->end()
                        ->variableNode('default')->end()
                    ->end()
                ->end()

                ->arrayNode('containers')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')
                                ->isRequired()
                            ->end()
                            ->scalarNode('script')
                                ->isRequired()
                            ->end()
                            ->scalarNode('version')
                                ->defaultValue('')
                            ->end()
                            ->scalarNode('alternative')
                                ->defaultValue('')
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('events')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->end()
                            ->scalarNode('function')->end()
                        ->end()
                    ->end()
                ->end()

            ->end()
        ;

        return $treeBuilder;
    }
}
