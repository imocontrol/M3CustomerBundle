<?php
namespace IMOControl\M3\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;

abstract class CustomerAddress
{

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    protected $street;

    /**
     * @var integer
     *
     * @ORM\Column(name="postalcode", type="integer")
     */
    protected $postalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=4)
     */
    protected $country;
	
	public function __toString() {
        return sprintf("%s, %s-%s", $this->getStreet(), $this->getPostalcode(), $this->getCity());
    }
    
    public function getFormatedCountry() {
        switch($this->country) {
            case 'AT': $c = 'Österreich'; break;
            case 'DE': $c = 'Deutschland'; break;
            case 'CH': $c = 'Schweiz'; break;
            case 'SI': $c = 'Slowenien'; break;
            case 'IT': $c = 'Italien'; break;
            default: $c = $this->country;
        }
        return $c;
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
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postalcode
     *
     * @param integer $postalcode
     * @return Address
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
    
        return $this;
    }

    /**
     * Get postalcode
     *
     * @return integer 
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }
}