<?php
namespace IMOControl\M3\CustomerBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;

interface CustomerInterface
{
    /**
	 * Return the customer as string.
	 * Required function to use in admin classes.
	 * @return string
	 */
	public function __toString();
	
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
	 * Iterate throw the contacts and find out the contact with the main flag.
	 * Otherwise if no main contact flag is set the contact on the first position
	 * will be selected.
	 *
	 * @return IMOControl\M3\CustomerBundle\Interfaces\ContactInterface|null
	 */
	public function getMainContact();
    
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
     * Set created_from
     *
     * @param datetime $created_from
     */
    public function setCreatedFrom($created_from);

    /**
     * Get created_from
     *
     * @return \IMOControl\M3\UserBundle\Model\Interfaces\SystemUserInterface 
     */
    public function getCreatedFrom();
    
    /**
     * Set updated_from
     *
     * @param datetime $updated_from
     */
    public function setUpdatedFrom($updated_from);

    /**
     * Get updated_from
     *
     * @return \IMOControl\M3\UserBundle\Model\Interfaces\SystemUserInterface 
     */
    public function getUpdatedFrom();
    
	/**
	 * Helper for to check if current customer is a company.
	 * 
	 * @return boolean true if customer is a company
	 */
	public function isCompany();
	
    /**
     * Set name of the customer or company name
     *
     * @param string $value
     */
    public function setName($value);

    /**
     * Get name of the customer or company name
     *
     * @return string 
     */
    public function getName();
    
	/**
     * Set the main office (headquater) address of the customer. Mostly used for the invoice address.
     *
     * @param AddressInterface $value
     */
    public function setOfficeAddress(AddressInterface $value);

    /**
     * Get current used office addresse of the customers headquater.
     *
     * @return CustomerAddress 
     */
    public function getOfficeAddress();
	
	/**
     * Set the delivery address of the customer.
     *
     * @param AddressInterface $value
     */
    public function setDeliveryAddress(AddressInterface $value);

    /**
     * Get current used delivery addresse of the customers where to send products or something else...
     *
     * @return AddressInterface 
     */
    public function getDeliveryAddress();
	
    /**
     * Set salutation_modus
     *
     * @param boolean $salutationModus
     * @return CustomerInterface
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
     * @return CustomerInterface
     */
    public function setCustomerType(CustomerTypeInterface $customerType);

    /**
     * Get customer_type
     *
     * @return string $customer_type Current assigned customer type: Company|Private|...
     */
    public function getCustomerType();
    
    public function getCustomerHasContacts();
	public function setCustomerHasContacts($value);
	public function addCustomerHasContacts(CustomerHasContactsInterface $object);
	
	public function getInternalName();
	public function setInternalName($value);
}