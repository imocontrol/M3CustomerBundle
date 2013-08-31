<?php
namespace IMOControl\M3\CustomerBundle\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use IMOControl\M3\CustomerBundle\Model\Interfaces\AddressInterface;

/**
 * ContactInterface
 *
 */
interface ContactInterface
{
    /**
	 * Return the contact as string.
	 * Required function to use in admin classes.
	 * @return string
	 */
	public function __toString();   
    
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
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setGender($gender);

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender();

    /**
     * Set address
     *
     * @param CustomerAddressInterface $address
     * @return Contact
     */
    public function setAddress(AddressInterface $address);

    /**
     * Get address
     *
     * @return CustomerAddress 
     */
    public function getAddress();

    /**
     * Set customer
     *
     * @param $customer_contacts
     * @return Contact
     */
    public function setCustomerHasContacts($customer_contacts);

    /**
     * Get customer has contacts
     *
     * @return $customer_has_contacts
     */
    public function getCustomerHasContacts();
}