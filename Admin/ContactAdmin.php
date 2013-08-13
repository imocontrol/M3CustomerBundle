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
use IMOControl\M3\CustomerBundle\Entity\Contact;
use IMOControl\M3\CustomerBundle\Entity\Customer;


class ContactAdmin extends CoreAdmin
{
	protected function configureRoutes(RouteCollection $collection)
    {
    }
	
	public function prePersist($object) {
		if ($object->getCustomer() instanceof Customer) {
			if ($object->getAddress() == null) {
				$object->setAddress($object->getCustomer()->getAddress());
			}
		}
	}
	
	public function preUpdate($object) {
		$this->prePersist($object);
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
                ->add('customer')
                ->add('fullName')
                ->add('address')
            ->end()
            ->with('Contact details')
                ->add('phone1')
                ->add('phone2')
                ->add('email')
            ->end();
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
    	//$ageQuery =  $this->modelManager->getEntityManager('M3AppScorezettelBundle:AgeGroup')->createQuery('SELECT a FROM M3AppScorezettelBundle:AgeGroup a WHERE a.enabled = true ORDER BY a.name ASC');
        
        if ($this->getRequest() && $customer_id = $this->getRequest()->get('customer_id')) {
        	if ($customer_id > 0) {
        		//$customerQuery =  $this->modelManager->getEntityManager('ApplicationM3IngBundle:Customer')->createQuery('SELECT a FROM ApplicationM3IngBundle:Customer a WHERE a.id = '.$customer_id.'');
                $oCustomer = $this->getModelManager()->find('ApplicationM3IngBundle:Customer', $customer_id);
                if ($oCustomer instanceof \Application\M3\IngBundle\Entity\Customer) {
                    $this->getSubject()->setCustomer($oCustomer);
                    //$this->update($this->getSubject());
                }
        	}
        }
        
        $formMapper
            ->with('General');
		if ($this->getRequest()->isXmlHttpRequest() && strpos($this->getRequest()->get('_sonata_name'), '_create') ) {
			$formMapper
					->add('customer', 'sonata_type_model_list', array('required' => true))
					;
					}
		$formMapper
				->add('position')
                ->add('salutation')
                ->add('firstname')
                ->add('lastname')
            ->end()
            ->with('Contact details')
                ->add('phone1')
                ->add('phone2')
                ->add('email')
                ->add('address', 'sonata_type_model_list', array('by_reference' => true, 'required' => false), array(
                'edit' => 'inline',
                'inline' => 'table',
            ))
                //->add('customer')
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
            ->addIdentifier('fullName')
            ->add('address')
            ->add('phone1')
            ->add('phone2')
            ->add('email')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array('template' => '::M3/actions/list__action_view.html.twig'),
                    'edit' => array('template' => '::M3/actions/list__action_edit.html.twig'),
                    'delete' => array('template' => '::M3/actions/list__action_delete.html.twig'),
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
        	->add('position')
        ;
    }
}