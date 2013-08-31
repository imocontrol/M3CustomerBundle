<?php
namespace IMOControl\M3\CustomerBundle\Model\Interfaces;

interface CustomerTypeInterface
{
	/**
	 * Return the customer type as string.
	 * Required function to use in admin classes.
	 * @return string
	 */
	public function __toString();
	
	/**
	 * @return string Unique name of the customer type.
	 */
	public function getName(); 
	
	/**
	 * Set an unique customer type name
	 *
	 * @param string $value
	 * @return CustomerTypeInterface
	 */
	public function setName($value);
	
	/**
	 * Status of the customer type.
	 *
	 * @return boolean
	 */
	public function isEnabled();
	
	/**
	 * Change customer type status. Disable => false Enable => true
	 *
	 * @param boolean $value
	 * @return CustomerTypeInterface
	 */
	public function setEnabled($value);
}