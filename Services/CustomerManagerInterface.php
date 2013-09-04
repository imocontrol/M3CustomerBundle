<?php
namespace IMOControl\M3\CustomerBundle\Services;

interface CustomerManagerInterface 
{
	/**
	 * Set the current customer entity object.
	 *
	 * @return \IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface $object
	 * @throw \InvalidArgumentException If invalid customer object assigned.
	 */
	public function setCustomer(\IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface $object);
	
	/**
	 * Return the current assigned customer entity object.
	 * Notice this property is required to call advanced methods of this class. So be sure
	 * to setCustomer before continue with other actions.
	 *
	 * @return \IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface $customer
	 * @throw \InvalidArgumentException If no customer object is set!
	 */
	public function getCustomer();
	
	/**
	 * Return the current absolute path of the customer folder.
	 *
	 * @return string
	 */
	public function getCustomerFolderPath();
}