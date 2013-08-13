<?php
namespace IMOControl\M3\CustomerBundle\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use IMOControl\M3\CustomerBundle\Model\CustomerAddress;

/**
 * ContactInterface
 *
 */
interface ContactInterface
{
       
    public function getFullName($nl='');
		
	public function getPostalSalutation($nl='');
    
    /**
     * Set position or department of a company contact person
     *
     * @param string $position
     * @return Contact
     */
    public function setPosition($position);

    /**
     * Get position of the contact person
     *
     * @return string 
     */
    public function getPosition();

    /**
     * Set salutation
     *
     * @param string $salutation
     * @return Contact
     */
    public function setSalutation($salutation);

    /**
     * Get salutation
     *
     * @return string 
     */
    public function getSalutation();
	
    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Contact
     */
    public function setFirstname($firstname);

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname();
    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Contact
     */
    public function setLastname($lastname);

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname();

    /**
     * Set phone1
     *
     * @param string $phone1
     * @return Contact
     */
    public function setPhone($phone);

    /**
     * Get phone1
     *
     * @return string 
     */
    public function getPhone();

    /**
     * Set phone2
     *
     * @param string $phone2
     * @return Contact
     */
    public function setPhoneMobile($phone);
	
    /**
     * Get phone2
     *
     * @return string 
     */
    public function getPhoneMobile();
	
    /**
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail();

    /**
     * Set address
     *
     * @param CustomerAddress $address
     * @return Contact
     */
    public function setAddress(CustomerAddress $address);

    /**
     * Get address
     *
     * @return CustomerAddress 
     */
    public function getAddress();

    /**
     * Set customer
     *
     * @param \IMOControl\M3\CustomerBundle\Model\CustomerInterface $customer
     * @return Contact
     */
    public function setCustomer(CustomerInterface $customer = null);

    /**
     * Get customer
     *
     * @return \IMOControl\M3\CustomerBundle\Model\Customer 
     */
    public function getCustomer();
}