<?php

namespace Obtao\RecombeeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $tb = new TreeBuilder();

        $rootNode = $tb->root('obtao_recombee');

        $rootNode
            ->children()
            ->scalarNode('recombee_secret_token')
            ->isRequired()
            ->end()
            ->scalarNode('recombee_database_name')
            ->isRequired()
            ->end()
            ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $tb;
    }
}
