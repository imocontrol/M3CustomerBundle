<?php

namespace IMOControl\M3\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;

use IMOControl\M3\CustomerBundle\Model\Contact as AbstractContact;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class BaseContact extends AbstractContact
{
	
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=100, nullable=true)
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(name="salutation", type="string", length=30)
     */
    protected $salutation;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=40, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_mobile", type="string", length=40, nullable=true)
     */
    protected $phone_mobile;

    /**
     * @var string
     *
     * @Assert\Email()
     * 
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * 
     * @var CustomerAddress $address
     */
    protected $address;
    
    /**
     * 
     */
    protected $customer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updated_at;

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
    
}