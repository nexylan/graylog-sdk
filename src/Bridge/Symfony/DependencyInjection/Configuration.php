<?php

declare(strict_types=1);

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\Graylog\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nexy_graylog');

        $rootNode
            ->children()
            ->arrayNode('options')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('base_uri')->isRequired()->end()
                ->end()
            ->end()
            ->arrayNode('auth')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('user')->info('Can be a username or a token.')->isRequired()->end()
                    ->scalarNode('password')->info('Required only for username auth.')->defaultNull()->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
