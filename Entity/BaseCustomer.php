<?php

namespace IMOControl\M3\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;

use IMOControl\M3\CustomerBundle\Model\Customer as AbstractCustomer;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class BaseCustomer extends AbstractCustomer
{
	/**
	 * Virtual form property.
	 * @var boolean $_change_internal_name
	 */
	protected $_change_internal_name = false;

    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->updated_at = null;
        $this->created_at = new \DateTime();
    }
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        $this->updated_at = new \DateTime();
    }
    
    
    public function __construct()
    {
    }
    
    /**
     * Virtual property getter if the internal name has to change.
     *
     * @return boolean
     */
    public function getChangeInternalName()
    {
    	return $this->_change_internal_name;
    }
    
    /**
     * Virtual property setter if the internal name has to change.
     *
     * @param boolean $value
     */
    public function setChangeInternalName($value)
    {
    	$this->_change_internal_name = $value;
    }
	
}