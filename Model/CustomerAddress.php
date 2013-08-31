<?php
namespace IMOControl\M3\CustomerBundle\Model;

use IMOControl\M3\CustomerBundle\Model\Interfaces\AddressInterface;
use Doctrine\ORM\Mapping as ORM;

abstract class CustomerAddress implements AddressInterface
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
	
	/**
     * {@inheritdoc}
     */
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
     * {@inheritdoc}
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * {@inheritdoc}
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * {@inheritdoc}
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * {@inheritdoc}
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        return $this->country;
    }
}