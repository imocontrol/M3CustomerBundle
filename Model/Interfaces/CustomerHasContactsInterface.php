<?php
namespace IMOControl\M3\CustomerBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;

interface CustomerHasContactsInterface
{
    /**
	 * Return the customer as string.
	 * Required function to use in admin classes.
	 * @return string
	 */
	public function __toString();
	
	public function getCustomer();
	public function setCustomer(CustomerInterface $customer);
	public function getContact();
	public function setContact(ContactInterface $contact);
	public function getPosition();
	public function setPosition($value);
	public function isEnabled();
	public function setEnabled($value);
    
}