<?php
namespace IMOControl\M3\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;

use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\ContactInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerHasContactsInterface;

abstract class CustomerHasContacts implements CustomerHasContactsInterface
{
	/**
     * @var string
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    protected $position;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    protected $enabled;
    
    protected $customer;
    
    protected $contact;
    
   /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;
   

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updated_at;
    
    
    public function __construct()
    {
    	$this->position = 0;
    	$this->enabled = true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
    	if (is_object($this->contact)) {
    		return sprintf("#%s-[%s] %s", $this->position, $this->contact->getPosition(), $this->contact->getFullName());
    	}
    	return 'Create Customer contact';    		
    }
    
   
    
    /**
     * {@inheritdoc}
     */
    public function getCustomer()
    {
    	return $this->customer;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCustomer(CustomerInterface $customer)
    {
    	$this->customer = $customer;
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getContact()
    {
    	return $this->contact;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setContact(ContactInterface $contact)
    {
    	$this->contact = $contact;
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
    	return $this->enabled;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEnabled($value)
    {
    	$this->enabled = $value;
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
    	return $this->position;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPosition($value)
    {
    	$this->position = $value;
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}