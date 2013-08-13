<?php

namespace IMOControl\M3\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;

use IMOControl\M3\CustomerBundle\Model\Customer as AbstractCustomer;

/**
 * ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class BaseCustomer extends AbstractCustomer
{
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
        $this->update_at = new \DateTime();
    }
    
    
    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

}