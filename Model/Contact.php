<?php
namespace IMOControl\M3\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\ContactInterface;
use IMOControl\M3\CustomerBundle\Model\CustomerAddress;


abstract class Contact implements ContactInterface
{

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
					$salutation = sprintf("%s %s", $this->getCustomer()->getCustomerType(), $this->getCustomer()->getCompany());
				} else {
					$salutation = sprintf("%s %s$nl z.H. %s", $this->getCustomer()->getCustomerType(), $this->getCustomer()->getCompany(), $this->getFullName());
				}
				break;
			case 'Privat':
				$salutation = $this->getFullName($nl);
				break;
			default:
				if ($this->getCustomer()->getSalutationModus()) {
					$salutation = sprintf("%s %s", $this->getCustomer()->getCustomerType(), $this->getCustomer()->getCompany());
				} else {
					$salutation = sprintf("%s$nl z.H. %s", $this->getCustomer()->getCompany(), $this->getFullName());
				}
				break;	
		}
        
        return $salutation;
    }
	
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
     * Set phone
     *
     * @param string $phone
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone1;
    
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
     * @param \stdClass $address
     * @return Contact
     */
    public function setAddress(CustomerAddress $address)
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
     * @param Customer $customer
     * @return Contact
     */
    public function setCustomer(CustomerInterface $customer = null)
    {
        $this->customer = $customer;
    
        return $this;
    }

    /**
     * Get customer
     *
     * @return Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}