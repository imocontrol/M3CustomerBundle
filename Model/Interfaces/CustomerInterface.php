<?php
namespace IMOControl\M3\CustomerBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;
use IMOControl\M3\CustomerBundle\Model\Interfaces\ContactInterface;
use IMOControl\M3\CustomerBundle\Model\CustomerAddress;

interface CustomerInterface
{
    /**
     * Get salutation for the customer. Check if company or not!
	 * Also used for invoice address. To get delivery address see getDeliverySalutation
	 * 
	 *  
	 * @param string $nl	 New line string if neccessary
	 * @param string $format Output syntax of the salutation
     */
    public function getSalutation($nl='');
    
    public function getFullName($nl='');
	
	public function getPostalSalutation($short=false);
    
	public function getPhoneNumbers();
	
	public function getContactsCount();
	
    
    /**
     * Set academic_title
     *
     * @param string $academicTitle
     */
    public function setAcademicTitle($academicTitle);

    /**
     * Get academic_title
     *
     * @return string 
     */
    public function getAcademicTitle();

    /**
     * Set firstname
     *
     * @param string $firstname
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
     */
    public function setLastname($lastname);

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname();

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail();

    /**
     * Set birthday
     *
     * @param date $birthday
     */
    public function setBirthday($birthday);

    /**
     * Get birthday
     *
     * @return date 
     */
    public function getBirthday();

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender);

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender();

    /**
     * Set uid_number
     *
     * @param string $uidNumber
     */
    public function setUidNumber($uidNumber);

    /**
     * Get uid_number
     *
     * @return string 
     */
    public function getUidNumber();
    
    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt();

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get updated_at
     *
     * @return datetime 
     */
    public function getUpdatedAt();
	
	/**
	 * Helper for to check if current customer is a company.
	 * 
	 * @return boolean true if customer is a company
	 */
	public function isCompany();
	
    /**
     * Set Company
     *
     * @param Company $value
     */
    public function setCompanyName($value);

    /**
     * Get Company
     *
     * @return Company 
     */
    public function getCompanyName();
    
	/**
     * Set the main office (headquater) address of the customer. Mostly used for the invoice address.
     *
     * @param CustomerAddress $value
     */
    public function setOfficeAddress(CustomerAddress $value);

    /**
     * Get current used office addresse of the customers headquater.
     *
     * @return CustomerAddress 
     */
    public function getOfficeAddress();
	
	/**
     * Set the delivery address of the customer.
     *
     * @param CustomerAddress $value
     */
    public function setDeliveryAddress(CustomerAddress $value);

    /**
     * Get current used delivery addresse of the customers where to send products or something else...
     *
     * @return CustomerAddress 
     */
    public function getDeliveryAddress();
	
    /**
     * Add contacts
     *
     * @param ContactInterface $contact
     * @return Customer
     */
    public function addContact(ContactInterface $contact);

    /**
     * Remove single contact
     *
     * @param ContactInterface $contacts
     */
    public function removeContact(ContactInterface $contact);

    /**
     * Get collection of all assigned contacts of the customer
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts();
    
	/**
	 * Assing a collaction of contacts to the customer
	 */
    public function setContacts(Collection $contacts);
	
    /**
     * Set salutation_modus
     *
     * @param boolean $salutationModus
     * @return Customer
     */
    public function setSalutationModus($salutationModus);

    /**
     * Get salutation_modus
     *
     * @return boolean 
     */
    public function getSalutationModus();

    /**
     * Set the type of a customer. Private persone, company, authority ...
     *
     * @param string $customerType
     * @return Customer
     */
    public function setCustomerType($customerType);

    /**
     * Get customer_type
     *
     * @return string $customer_type Current assigned customer type: Company|Private|...
     */
    public function getCustomerType();
}