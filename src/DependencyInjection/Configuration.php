<?php

namespace AshleyDawson\DoctrineFlysystemBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class Configuration
 *
 * @package AshleyDawson\DoctrineFlysystemBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('ashley_dawson_doctrine_flysystem');

        // ...

        return $treeBuilder;
    }
}