<?php

namespace IMOControl\M3\CustomerBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Knp\Menu\ItemInterface as MenuItemInterface;

use IMOControl\M3\CustomerBundle\Entity\Customer;
use IMOControl\M3\CustomerBundle\Entity\CustomerAddress as Address;
use IMOControl\M3\CustomerBundle\Entity\Contact;

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
        	->add('customer_type', 'choice', array('choices' => array('Privat' => 'Privat', 'Firma' => 'Firma', 'Gemeinde' => 'Gemeinde', 'Abwassergenossenschaft' => 'Abwassergenossenschaft', 'Alpenverein' => 'Alpenverein', 'Verein' => 'Verein')))
            ->add('fullName')
            ->add('address')
        ;
    }
    
    public function postPersist($object)
    {
    	$flag_main_contact = false;
         foreach($object->getContacts() as $key => $item) {
             $item->setCustomer($object);
			 
			 if ($item->getPosition() == 'Auftraggeber') {
			 	$flag_main_contact = true;
				$item->setAddress($object->getAddress());
				$item->setSalutation($object->getGender() . " " . $object->getAcademicTitle());
				$item->setFirstname($object->getFirstname());
				$item->setLastname($object->getLastname());
				$item->setPhone1($object->getPhone());
				$item->setPhone2($object->getPhoneMobile());
				$item->setEmail($object->getEmail());
			 }
			 
			 if ($item->getAddress() == null) {
			 	$item->setAddress($object->getAddress());
			 }
         }
		 
		 // Notice we have to set one main contact which gets invoices of the project...
		 // Otherwise no contact exists with position "Auftraggeber" the init Contact will be assigned
		 if (!$flag_main_contact) {
		 	$main_contact = new Contact();
			$main_contact->setAddress($object->getAddress());
			$main_contact->setPosition('Auftraggeber');
			$main_contact->setSalutation($object->getGender() . " " . $object->getAcademicTitle());
			$main_contact->setFirstname($object->getFirstname());
			$main_contact->setLastname($object->getLastname());
			$main_contact->setPhone1($object->getPhone());
			$main_contact->setPhone2($object->getPhoneMobile());
			$main_contact->setEmail($object->getEmail());
			$main_contact->setCustomer($object);
			$this->getModelManager()->update($main_contact);	
		 }
		 
		 $this->getModelManager()->update($object);
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
        
        $formMapper
            ->with('General')
				->add('customer_type', 'choice', array('choices' => array('Privat' => 'Privat', 'Firma' => 'Firma', 'Gemeinde' => 'Gemeinde', 'Abwassergenossenschaft' => 'Abwassergenossenschaft', 'Alpenverein' => 'Alpenverein', 'Verein' => 'Verein', 'Privatstiftung' => 'Privatstiftung')))
                ->add('company')
                ->add('gender', 'choice', array('choices' => array('Herr' => 'Herr', 'Frau' => 'Frau')))
                ->add('academic_title')
                ->add('firstname')
                ->add('lastname')
				->add('office_address', 'sonata_type_model_list', array('by_reference' => true))
				->add('delivery_address', 'sonata_type_model_list', array('by_reference' => true))
                ->add('uid_number')
                ->add('salutation_modus', 'checkbox', array('required' => false, 'help' => 'Bei Firmenadressen wird das "z.H. Personenbezeichnung" weggelassen und nur der Firmenname als Anrede verwendet.'))
                ->add('email', 'email', array('help' => 'Wird für den Rechnungsversand per E-Mail benötigt.', 'required' => false))
                ->add('phone')
                ->add('phone_mobile')
                //->add('contacts', 'sonata_type_model', array('required' => false, 'expanded' => true, 'multiple' => true))
             ->end()
             ->with('Contact types', array('collapsed' => true))
                ->add('contacts', 'sonata_type_collection', array('required' => false,
                                                                  'by_reference' => false,
                                                                  ),
                                                            array('edit' => 'inline',
                                                                  'inline' => 'table',))
                /* ->add('contact1', 'sonata_type_immutable_array', array('keys' => array(
                                                                           array('position',        'text', array('required' => false)),
                                                                            array('person_name',   'text',  array('required' => false)),
                                                                            array('phone1',     'text',  array('required' => false)),
                                                                            array('phone2',     'text',  array('required' => false)),
                                                                            array('email',     'email',  array('required' => false)),
                                                                        )))
                 // */
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
            ->add('customer_type', 'choice', array('choices' => array('Privat' => 'Privat', 'Firma' => 'Firma', 'Abwassergenossenschaft' => 'Abwassergenossenschaft', 'Gemeinde' => 'Gemeinde', 'Alpenverein' => 'Alpenverein', 'Verein' => 'Verein')))
            ->addIdentifier('company')
            ->add('fullName', null, array('label' => 'Hauptansprechperson'))
			->add('phoneNumbers', null, array('template' => '::M3/CRUD/list_field_html.html.twig'))
			->add('office_address')
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
        	->add('customer_type', null, array(), 'choice', array('choices' => array('Privat' => 'Privat', 'Firma' => 'Firma', 'Gemeinde' => 'Gemeinde', 'Abwassergenossenschaft' => 'Abwassergenossenschaft', 'Alpenverein' => 'Alpenverein', 'Verein' => 'Verein')))
            ->add('company')
            ->add('lastname')
            ->add('contacts')
			->add('address.postalcode')
			->add('address.city')
        ;
    }
    
    
    
}