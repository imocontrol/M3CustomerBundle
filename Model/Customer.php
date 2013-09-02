<?php
namespace IMOControl\M3\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerTypeInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerHasContactsInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\ContactInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\AddressInterface;

abstract class Customer implements CustomerInterface
{
	
	const TYPE_PRIVATE = 0;
	const TYPE_COMPANY = 1;
	const TYPE_AUTHORITY = 2;
	
	/**
     * @var CustomerTypeInterface $customer_type
     */
    protected $customer_type;
	
    /**
     * Get the customers name or company name. This is the first line for the postal address 
     * or for __toString method.
     *
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    protected $name;
    
    /**
     * Holds an internal name of the customer which must be unique. It's also used for
     * the customer folder.
     *
     * @var string $name
     * 
     * @ORM\Column(name="internal_name", type="string", unique=true, length=100)
     */
    protected $internal_name;
    
    /**
     * @var string $uid_number
     *
     * @ORM\Column(name="uid_number", type="string", length=30, nullable=true)
     */
    protected $uid_number;
    
  
    /**
     * @var CustomerAddress $office_address
     */
    protected $office_address;
	
	/**
     * @var CustomerAddress $delivery_address
     */
    protected $delivery_address;
    
    
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
    
    
    /**
     * //old: OneToMany(targetEntity="Contact", mappedBy="customer", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $customer_has_contacts;
    
    /**
     * @var boolean $salutation_modus
     *
     * @ORM\Column(name="salutation_modus", type="boolean", nullable=true)
     */
    protected $salutation_modus;
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->updated_at = null;
        $this->created_at = new \DateTime();
    }
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        $this->update_at = new \DateTime();
    }
    
    public function __toString() {
        return  sprintf("%s %s", $this->getCustomerType(), $this->getName());
    }
    
    public function __construct()
    {
        
    }

    
    /**
     * Get salutation for the customer. Check if company or not!
     */
    public function getSalutation($nl='')
    {
		switch($this->getCustomerType()) {
			case 'Firma':
			case 'Gemeinde':
			case 'Abwassergenossenschaft':
				if ($this->getSalutationModus()) {
					$salutation = sprintf("%s %s", $this->getCustomerType(), $this->getCompany());
				} else {
					$salutation = sprintf("%s %s$nl z.H. %s", $this->getCustomerType(), $this->getCompany(), $this->getFullName());
				}
				break;
			case 'Privat':
				$salutation = $this->getFullName($nl);
				break;
			default:
				if ($this->getSalutationModus()) {
					$salutation = sprintf("%s %s", $this->getCustomerType(), $this->getCompany());
				} else {
					$salutation = sprintf("%s$nl z.H. %s", $this->getCompany(), $this->getFullName());
				}
				break;	
		}
        
        return $salutation;
    }
    
    public function getFullName($nl='') {
//         return sprintf("%s$nl %s %s %s", $this->getGender(), $this->getAcademicTitle(), $this->getFirstname(), $this->getLastname());
    	return $this->name;
    }
	
	public function getPostalSalutation($short=false) {
		$pre_gender = ($this->getGender() == 'Herr') ? 'Sehr geehrter' : 'Sehr geehrte';
		$name = $this->getFullName();
		
		if ($short) {
			$name = $this->getGender() . " " . $this->getLastname();
		}
		
		return sprintf("%s %s", $pre_gender, $name);
	}
    
	public function getPhoneNumbers() {
		return sprintf("Tel.: %s <br/>Mob.: %s", $this->getPhone(), $this->getPhoneMobile());
	}
	
	public function getContactsCount() {
		return count($this->getContacts());
	}
	
	public function isCompany() {
		return ($this->customer_type == 'Firma') ? true : false;
	}
	
    // End  Helpers

    /**
     * {@inheritdoc}
     */
    public function setUidNumber($uidNumber)
    {
        $this->uid_number = $uidNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getUidNumber()
    {
        return $this->uid_number;
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

    /**
     * {@inheritdoc}
     */
    public function setUpdatedFrom($updatedFrom)
    {
        $this->updated_from = $updatedFrom;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedFrom()
    {
        return $this->updated_from;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * {@inheritdoc} 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setInternalName($value)
    {
        $this->internal_name = $value;
        return $this;
    }

    /**
     * {@inheritdoc} 
     */
    public function getInternalName()
    {
        return $this->internal_name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOfficeAddress(AddressInterface $value)
    {
        $this->office_address = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOfficeAddress()
    {
        return $this->office_address;
    }
	
	/**
     * {@inheritdoc}
     */
    public function setDeliveryAddress(AddressInterface $value)
    {
        $this->delivery_address = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeliveryAddress()
    {
        return $this->delivery_address;
    }
    
	/**
     * {@inheritdoc}
     */
    public function setSalutationModus($salutationModus)
    {
        $this->salutation_modus = $salutationModus;
    
        return $this;
    }

    /**
     * {@inheritdoc} 
     */
    public function getSalutationModus()
    {
        return $this->salutation_modus;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomerType(CustomerTypeInterface $customerType)
    {
        $this->customer_type = $customerType;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerType()
    {
        return $this->customer_type;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCustomerHasContacts() 
    {
    	return $this->customer_has_contacts;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCustomerHasContacts($value)
    {
    	$this->customer_has_contacts = $value;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addCustomerHasContacts(CustomerHasContactsInterface $customerHasContact)
    {
        $customerHasContact->setCustomer($this);

        $this->customer_has_contacts[] = $customerHasContact;
    }
}