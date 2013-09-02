<?php

namespace IMOControl\M3\CustomerBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Knp\Menu\ItemInterface as MenuItemInterface;

use IMOControl\M3\AdminBundle\Admin\Admin as CoreAdmin;

class CustomerAdmin extends CoreAdmin
{
	/**
	 * @var \IMOControl\M3\CustomerBundle\Services\CustomerManager $manager
	 */
	protected $manager;
	
	/**
	 * Set the customer manager service.
	 * Should always be injected by the service container.
	 *
	 * @param \IMOControl\M3\CustomerBundle\Services\CustomerManager $instance
	 */
	public function setManager($instance)
	{
		$this->manager = $instance;
	}
	
	/**
	 * {@inhiredoc}
	 */
	public function prePersist($object)
    {
    	
    }
    
    public function postPersist($object)
    {
    	$object->setInternalName($this->manager->generateCustomerInternalName());
    	$this->assignContactsToCustomer($object);
    	$this->manager->setCustomer($object);
    	$this->manager->createCustomerFolder();
    }
    
    public function preUpdate($object)
    {
    	if ($object->getChangeInternalName()) {
    		$object->setInternalName($this->manager->generateCustomerInternalName(true));
    	} else {
    		$object->setInternalName($this->manager->generateCustomerInternalName());
    	}
    }
    
    public function postUpdate($object)
    {
		$this->assignContactsToCustomer($object);
    }
	
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
        	->with('General')
        	->add('customer_type')
        	->add('internal_name')
            ->add('fullName')
            ->add('office_address')
            ->add('delivery_address')
            ->end()
            ->with('Contacts')
            	->add('customer_has_contacts')
            ->end()
        ;
    }
    
    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $context = array();
        $this->manager->setCustomer($this->getSubject());
        
        $formMapper
            ->with('General')
				->add('customer_type', 'sonata_type_model', array('required' => true, 
																  'expanded' => false,
																  'multiple' => false,
																  'by_reference' => true,
																  'class' => 'ApplicationIMOControlM3CustomerBundle:CustomerType'))
				->add('name')
				->add('internal_name', null, array('read_only' => true))
				->add('change_internal_name', 'checkbox', array('virtual' => false,
																'required'=> false,
																'help'	  => 'help_customer_change_internal_name',
																'data'	  => false,
																))
				->add('office_address', 'sonata_type_model_list', array('by_reference' => true))
				->add('delivery_address', 'sonata_type_model_list', array('by_reference' => true))
                ->add('uid_number')
                ->add('salutation_modus', 'checkbox', array('required' => false, 'help' => 'Bei Firmenadressen wird das "z.H. Personenbezeichnung" weggelassen und nur der Firmenname als Anrede verwendet.'))
             ->end();
             
        $formMapper
             ->with('Contact types', array('collapsed' => true))
                ->add('customer_has_contacts', 'sonata_type_collection', array(
                	'cascade_validation' => true,
                	), array(
                    	'edit'              => 'inline',
                    	'inline'            => 'table',
                    	'sortable'          => 'position',
                    	'link_parameters'   => array('context' => $context),
                    	'admin_code'        => 'imocontrol.customer_has_contacts'
                	)
            	)
            ->end();
            
        $formMapper
             ->with('Systeminfos', array('collapsed' => true))
                ->add('created_at')
                ->add('created_from')
                ->add('updated_at')
                ->add('updated_from')
            ->end();
		
		
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('customer_type')
            ->addIdentifier('name')
			->add('office_address')
			->add('delivery_address')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        	->add('customer_type.name')
            ->add('name')
			->add('office_address.postalcode')
			->add('office_address.city')
        ;
    }
    
    protected function assignContactsToCustomer($object) 
    {
    	foreach($object->getCustomerHasContacts() as $key => $item) {
    		$item->setCustomer($object);
    		$this->getModelManager()->update($item);
    	}
    	$object->setCustomerHasContacts($object->getCustomerHasContacts());
    }
    
    
}