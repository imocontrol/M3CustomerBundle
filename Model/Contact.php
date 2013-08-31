<?php
namespace IMOControl\M3\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\ContactInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\AddressInterface;


abstract class Contact implements ContactInterface
{
	/**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=100, nullable=true)
     */
    protected $position;
	
	/**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=20)
     */
    protected $gender;
    
    /**
     * @var string
     *
     * @ORM\Column(name="salutation", type="string", length=30)
     */
    protected $salutation;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    protected $lastname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=40, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_mobile", type="string", length=40, nullable=true)
     */
    protected $phone_mobile;

    /**
     * @var string
     *
     * @Assert\Email()
     * 
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * 
     * @var CustomerAddress $address
     */
    protected $address;
    
    /**
     * 
     */
    protected $customer_has_contacts;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updated_at;
    
    public function __toString() {
        return sprintf("[%s]-%s %s %s", $this->getPosition(), $this->getSalutation(), $this->getFirstname(), $this->getLastname());
    }
    
    public function __construct() {

    }
    
    public function getFullName($nl='') {
        return sprintf("%s$nl %s %s", $this->getSalutation(), $this->getFirstname(), $this->getLastname());
    }
		
	public function getPostalSalutation($nl='')
    {
		switch($this->getCustomer()->getCustomerType()) {
			case 'Firma':
			case 'Gemeinde':
				if ($this->getCustomer()->getSalutationModus()) {
					$salutation = sprintf("%s %s", $this->getCustomer()->getCustomerType(), $this->getCustomer()->getName());
				} else {
					$salutation = sprintf("%s %s$nl z.H. %s", $this->getCustomer()->getCustomerType(), $this->getCustomer()->getName(), $this->getFullName());
				}
				break;
			case 'Privat':
				$salutation = $this->getFullName($nl);
				break;
			default:
				if ($this->getCustomer()->getSalutationModus()) {
					$salutation = sprintf("%s %s", $this->getCustomer()->getCustomerType(), $this->getCustomer()->getName());
				} else {
					$salutation = sprintf("%s$nl z.H. %s", $this->getCustomer()->getName(), $this->getFullName());
				}
				break;	
		}
        
        return $salutation;
    }
	
    

    /**
     * Set position
     *
     * @param string $position
     * @return Contact
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set salutation
     *
     * @param string $salutation
     * @return Contact
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;
        return $this;
    }

    /**
     * Get salutation
     *
     * @return string 
     */
    public function getSalutation()
    {
        return $this->salutation;
    }
	
    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Contact
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Contact
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setGender($gender)
    {
    	$this->gender = $gender;
    	return $this;
    }
    

    /**
     */
    public function getGender()
    {
    	return $this->gender;
    }
    
    /**
     * Set phone
     *
     * @param string $phone
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phone2
     *
     * @param string $phone2
     * @return Contact
     */
    public function setPhoneMobile($phone)
    {
        $this->phone_mobile = $phone;
        return $this;
    }

    /**
     * Get phone2
     *
     * @return string 
     */
    public function getPhoneMobile()
    {
        return $this->phone_mobile;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param CustomerAddressInterface $address
     * @return Contact
     */
    public function setAddress(AddressInterface $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return \stdClass 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Contact
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Contact
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set customer
     *
     * @param CustomerHasContacts $customer_contacts
     * @return Contact
     */
    public function setCustomerHasContacts($customer_contacts)
    {
        $this->customer_has_contacts = $customer_contacts;
        return $this;
    }

    /**
     * Get customer
     *
     * @return Customer 
     */
    public function getCustomerHasContacts()
    {
        return $this->customer_has_contacts;
    }
}