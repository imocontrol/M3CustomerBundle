<?php

namespace IMOControl\M3\CustomerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IMOControlM3CustomerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('admin_services.yml');
        
        $this->registerDoctrineMappings($config);
    }
    
    
    protected function registerDoctrineMappings($config)
	{
	
		//echo "<pre>" . print_r($config, true) . "</pre>";
		//die();
		foreach ($config['class'] as $type => $class) {
            if (!class_exists($class)) {
                return;
            }
        }

        $collector = DoctrineCollector::getInstance();

        $collector->addAssociation($config['class']['customer'], 'mapManyToOne', array(
            'fieldName'     => 'office_address',
            'targetEntity'  => $config['class']['customer_address'],
            'cascade'       => array(
                'all',
            ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'  => 'proj',
                    'referencedColumnName' => 'id',
                    'onDelete' => 'CASCADE',
                ),
            ),
            'orphanRemoval' => true,
        ));
        
        $collector->addAssociation($config['class']['customer'], 'mapManyToOne', array(
            'fieldName'     => 'delivery_address',
            'targetEntity'  => $config['class']['customer_address'],
            'cascade'       => array(
                'all',
            ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'  => 'proj',
                    'referencedColumnName' => 'id',
                    'onDelete' => 'CASCADE',
                ),
            ),
            'orphanRemoval' => true,
        ));
        
        $collector->addAssociation($config['class']['contact'], 'mapManyToOne', array(
            'fieldName'     => 'address',
            'targetEntity'  => $config['class']['customer_address'],
            'cascade'       => array(
                'all',
            ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'  => 'proj',
                    'referencedColumnName' => 'id',
                    'onDelete' => 'CASCADE',
                ),
            ),
            'orphanRemoval' => true,
        ));
	}
}
