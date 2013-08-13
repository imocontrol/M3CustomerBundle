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
        
        $this->initApplicationConfig($config, $container);
        $this->registerDoctrineMappings($config);
    }
    
    protected function initApplicationConfig($config, $container) 
	{
		$container->setParameter('imocontrol.customer.admin.class', $config['admin']['customer']['class']);
		$container->setParameter('imocontrol.customer.admin.entity.class', $config['admin']['customer']['entity']);
		$container->setParameter('imocontrol.customer.admin.controller.class', $config['admin']['customer']['controller']);
		$container->setParameter('imocontrol.customer.admin.translation', $config['admin']['customer']['translation']);
		
		$container->setParameter('imocontrol.customer_address.admin.class', $config['admin']['customer_address']['class']);
		$container->setParameter('imocontrol.customer_address.admin.entity.class', $config['admin']['customer_address']['entity']);
		$container->setParameter('imocontrol.customer_address.admin.controller.class', $config['admin']['customer_address']['controller']);
		$container->setParameter('imocontrol.customer_address.admin.translation', $config['admin']['customer_address']['translation']);
		
		$container->setParameter('imocontrol.contact.admin.class', $config['admin']['contact']['class']);
		$container->setParameter('imocontrol.contact.admin.entity.class', $config['admin']['contact']['entity']);
		$container->setParameter('imocontrol.contact.admin.controller.class', $config['admin']['contact']['controller']);
		$container->setParameter('imocontrol.contact.admin.translation', $config['admin']['contact']['translation']);
		
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
