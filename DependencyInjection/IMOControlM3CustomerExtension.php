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
		$container->setParameter('imocontrol.customer_type.admin.class', $config['admin']['customer_type']['class']);
		$container->setParameter('imocontrol.customer_type.admin.entity.class', $config['admin']['customer_type']['entity']);
		$container->setParameter('imocontrol.customer_type.admin.controller.class', $config['admin']['customer_type']['controller']);
		$container->setParameter('imocontrol.customer_type.admin.translation', $config['admin']['customer_type']['translation']);
		
		
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
		
		$container->setParameter('imocontrol.customer_has_contacts.admin.class', $config['admin']['customer_has_contacts']['class']);
		$container->setParameter('imocontrol.customer_has_contacts.admin.entity.class', $config['admin']['customer_has_contacts']['entity']);
		$container->setParameter('imocontrol.customer_has_contacts.admin.controller.class', $config['admin']['customer_has_contacts']['controller']);
		$container->setParameter('imocontrol.customer_has_contacts.admin.translation', $config['admin']['customer_has_contacts']['translation']);
		
	}
    
    protected function registerDoctrineMappings($config)
	{
	
		//echo "<pre>" . print_r($config, true) . "</pre>";
		//die();
		

        $collector = DoctrineCollector::getInstance();

        $collector->addAssociation($config['admin']['customer']['entity'], 'mapManyToOne', array(
            'fieldName'     => 'office_address',
            'targetEntity'  => $config['admin']['customer_address']['entity'],
            'cascade'       => array(
                'all',
            ),
            'mappedBy'      => null,
            'inversedBy'    => null,
        ));
        
        $collector->addAssociation($config['admin']['customer']['entity'], 'mapManyToOne', array(
            'fieldName'     => 'delivery_address',
            'targetEntity'  => $config['admin']['customer_address']['entity'],
            'cascade'       => array(
                'all',
            ),
            'mappedBy'      => null,
            'inversedBy'    => null,
        ));
        
		// Adding Contact's mapping
        $collector->addAssociation($config['admin']['contact']['entity'], 'mapOneToMany', array(
            'fieldName'     => 'customer_has_contacts',
            'targetEntity'  => $config['admin']['customer_has_contacts']['entity'],
            'cascade'       => array(
                'persist',
            ),
            'mappedBy'      => 'contact',
            'orphanRemoval' => false,
        ));
        
        $collector->addAssociation($config['admin']['customer_has_contacts']['entity'], 'mapManyToOne', array(
            'fieldName'     => 'customer',
            'targetEntity'  => $config['admin']['customer']['entity'],
            'cascade'       => array(
                'persist',
            ),
            'mappedBy'      => NULL,
            'inversedBy'    => 'customer_has_contacts',
            'joinColumns'   =>  array(
                array(
                    'name'  => 'customer_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        $collector->addAssociation($config['admin']['customer_has_contacts']['entity'], 'mapManyToOne', array(
            'fieldName'     => 'contact',
            'targetEntity'  => $config['admin']['contact']['entity'],
            'cascade'       => array(
                'persist',
            ),
            'mappedBy'      => NULL,
            'inversedBy'    => 'customer_has_contacts',
            'joinColumns'   =>  array(
                array(
                    'name'  => 'contact_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        
        $collector->addAssociation($config['admin']['customer']['entity'], 'mapOneToMany', array(
            'fieldName'     => 'customer_has_contacts',
            'targetEntity'  => $config['admin']['customer_has_contacts']['entity'],
            'cascade'       => array(
                'persist',
            ),
            'mappedBy'      => 'customer',
            'orphanRemoval' => true,
            'orderBy'       => array(
                'position'  => 'ASC',
            ),
        ));
        
        $collector->addAssociation($config['admin']['customer']['entity'], 'mapManyToOne', array(
            'fieldName'     => 'customer_type',
            'targetEntity'  => $config['admin']['customer_type']['entity'],
            'cascade'       => array(
                'persist',
            ),
            'mappedBy'      => NULL,
            'inversedBy'    => NULL,
            'joinColumns'   =>  array(
                array(
                    'name'  => 'customer_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));
        
        // Add Contact mappings
        $collector->addAssociation($config['admin']['contact']['entity'], 'mapManyToOne', array(
            'fieldName'     => 'address',
            'targetEntity'  => $config['admin']['customer_address']['entity'],
            'cascade'       => array(
                'persist',
            ),
            'mappedBy'      => NULL,
            'inversedBy'    => NULL,
            'joinColumns'   =>  array(
                array(
                    'name'  => 'contact_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));
	}
}
