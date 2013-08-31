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
	
	
	protected function configureRoutes(RouteCollection $collection)
    {
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
            ->add('fullName')
            ->add('address')
            ->end()
            ->with('Contacts')
            	->add('customer_has_contacts')
            ->end()
        ;
    }
    
    public function postPersist($object)
    {
    	foreach($object->getCustomerHasContacts() as $key => $item) {
    		$item->setCustomer($object);
    		$this->getModelManager()->update($item);
    	}
    	$object->setCustomerHasContacts($object->getCustomerHasContacts());
    }
    
    public function postUpdate($object)
    {
        $this->postPersist($object);
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $context = array();
        
        $formMapper
            ->with('General')
				->add('customer_type', 'sonata_type_model', array('required' => true, 
																  'expanded' => false,
																  'multiple' => false,
																  'by_reference' => true,
																  'class' => 'ApplicationIMOControlM3CustomerBundle:CustomerType'))
				->add('name')
				->add('office_address', 'sonata_type_model_list', array('by_reference' => true))
				->add('delivery_address', 'sonata_type_model_list', array('by_reference' => true))
                ->add('uid_number')
                ->add('salutation_modus', 'checkbox', array('required' => false, 'help' => 'Bei Firmenadressen wird das "z.H. Personenbezeichnung" weggelassen und nur der Firmenname als Anrede verwendet.'))
             ->end()
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
    
    
    
}