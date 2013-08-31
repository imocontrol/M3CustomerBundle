<?php
namespace IMOControl\M3\CustomerBundle\Model\Interfaces;

interface AddressInterface
{
    /**
	 * Return the full address as string.
	 * Required function to use in admin classes.
	 * @return string
	 */
	public function __toString();
	
    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street);

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet();

    /**
     * Set postalcode
     *
     * @param integer $postalcode
     * @return AddressInterface
     */
    public function setPostalcode($postalcode);

    /**
     * Get postalcode
     *
     * @return integer 
     */
    public function getPostalcode();

    /**
     * Set city
     *
     * @param string $city
     * @return AddressInterface
     */
    public function setCity($city);

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity();

    /**
     * Set country
     *
     * @param string $country
     * @return AddressInterface
     */
    public function setCountry($country);

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry();
}