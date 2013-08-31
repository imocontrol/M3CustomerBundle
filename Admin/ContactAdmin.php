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

class ContactAdmin extends CoreAdmin
{
	protected function configureRoutes(RouteCollection $collection)
    {
    }
	
	public function prePersist($object) {
		
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
            	->add('position')
                ->add('fullName')
                ->add('address')
            ->end()
            ->with('Contact details')
                ->add('phone')
                ->add('phone_mobile')
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
        
        $formMapper
            ->with('General')
				->add('position')
				->add('gender')
                ->add('salutation')
                ->add('firstname')
                ->add('lastname')
            ->end()
            ->with('Contact details')
                ->add('phone')
                ->add('phone_mobile')
                ->add('email')
                ->add('address', 'sonata_type_model_list', array('by_reference' => true, 'required' => false), array(
                'edit' => 'inline',
                'inline' => 'table',
            ))
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
            ->add('position')
            ->add('address')
            ->add('phone1')
            ->add('phone2')
            ->add('email')
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
        	->add('position')
        ;
    }
}