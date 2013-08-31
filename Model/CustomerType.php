<?php
namespace IMOControl\M3\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerTypeInterface;

/**
 * @UniqueEntity(fields="name")
 */
abstract class CustomerType implements CustomerTypeInterface
{
	
	
	/**
     * @var string $name
     * @ORM\Column(name="name", type="string", length=40, nullable=false, unique=true)
     */
    protected $name;
	
    /**
     * @var boolean $enabled
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    protected $enabled;
    
    /**
     * {@inheritdoc}
     */
    public function __toString() {
        return  $this->getName();
    }
    
    public function __construct()
    {
        $this->enabled = true;
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
     * {@inheritdoc}
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEnabled($value)
    {
        $this->enabled = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}