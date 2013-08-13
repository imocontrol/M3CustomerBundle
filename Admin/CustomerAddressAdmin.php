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

class CustomerAddressAdmin extends CoreAdmin
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
            ->add('fullName')
            ->add('postalcode', 'number')
            ->add('city')
            ->add('country')
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
        
        $formMapper
            ->with('General')
                ->add('street')
                ->add('postalcode', 'number')
                ->add('city')
                ->add('country', 'country', array('preferred_choices' => array('AT', 'DE','HU', 'CH', 'SI')))
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
            ->addIdentifier('street')
            ->add('postalcode', 'number')
            ->add('city')
            ->add('country')
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
            ->add('street')
            ->add('postalcode')
            ->add('city')
            ->add('country')
        ;
    }
}