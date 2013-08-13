<?php

namespace IMOControl\M3\CustomerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('imo_control_m3_customer');
        $rootNode
			->children()
				->scalarNode('customer_folder_root_dir')->defaultValue("%kernel.root_dir%/data/customers/")->end()
            	->arrayNode('class')
            		->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('project')->cannotBeEmpty()->defaultValue('IMOControl\M3\ProjectBundle\Entity\Project')->end()
                        ->scalarNode('invoice')->cannotBeEmpty()->defaultValue('IMOControl\M3\InvoiceBundle\Entity\Invoice')->end()
                    ->end()
                ->end()
                ->arrayNode('admin')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('customer')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('IMOControl\M3\CustomerBundle\Admin\CustomerAdmin')->end()
                                ->scalarNode('entity')->cannotBeEmpty()->defaultValue('IMOControl\M3\CustomerBundle\Entity\Customer')->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue('IMOControlM3CustomerBundle:CRUD')->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue('default')->end()
                            ->end()
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('customer_address')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('IMOControl\M3\CustomerBundle\Admin\CustomerAddressAdmin')->end()
                                ->scalarNode('entity')->cannotBeEmpty()->defaultValue('IMOControl\M3\CustomerBundle\Entity\CustomerAddress')->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue('IMOControlM3CustomerBundle:CRUD')->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue('default')->end()
                            ->end()
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('contact')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('IMOControl\M3\CustomerBundle\Admin\ContactAdmin')->end()
                                ->scalarNode('entity')->cannotBeEmpty()->defaultValue('IMOControl\M3\CustomerBundle\Entity\Contact')->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue('IMOControlM3CustomerBundle:CRUD')->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue('default')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
