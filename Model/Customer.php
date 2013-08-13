<?php
namespace IMOControl\M3\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface;	
use IMOControl\M3\CustomerBundle\Model\Interfaces\ContactInterface;
use IMOControl\M3\CustomerBundle\Model\CustomerAddress;

/**
 * ORM\MappedSuperclass()
 */
abstract class Customer implements CustomerInterface
{
	
	const TYPE_PRIVATE = 0;
	const TYPE_COMPANY = 1;
	const TYPE_AUTHORITY = 2;
	
	
	/**
     * @var string $customer_type
     * @ORM\Column(name="customer_type", type="string", length=40, nullable=true)
     */
    protected $customer_type;
	
    /**
     * @var string $academic_title
     *
     * @ORM\Column(name="academic_title", type="string", length=40, nullable=true)
     */
    protected $academic_title;

    /**
     * @var string $firstname
     * 
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="firstname", type="string", length=60, nullable=true)
     */
    protected $firstname;
    
    /**
     * @var string $lastname
     * 
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="lastname", type="string", length=60)
     */
    protected $lastname;

    /**
     * @var string $email
     *
     * @Assert\Email(message="Die eingegebenen Emailadresse ist nicht gültig!")
     * 
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    protected $email;


    /**
     * @var string $gender
     *
     * @ORM\Column(name="gender", type="string", length=10)
     */
    protected $gender;
    
    /**
     * @var string $company
     * 
     * @ORM\Column(name="company", type="string", length=100, nullable=true)
     */
    protected $company;
    
    /**
     * @var string $phone
     * 
     * @ORM\Column(name="phone", type="string", length=30, nullable=true)
     */
    protected $phone;
    
    /**
     * @var string $company
     * 
     * @ORM\Column(name="phone_mobile", type="string", length=30, nullable=true)
     */
    protected $phone_mobile;
    
    /**
     * @var string $uid_number
     *
     * @ORM\Column(name="uid_number", type="string", length=30, nullable=true)
     */
    protected $uid_number;
    
  
    /**
     * //@ORM\ManyToOne(targetEntity="CustomerAddress")
     * //@ORM\JoinColumn(name="office_address", referencedColumnName="id")
     *
     * @var CustomerAddress $office_address
     */
    protected $office_address;
	
	/**
     * //@ORM\ManyToOne(targetEntity="CustomerAddress")
     * //@ORM\JoinColumn(name="address", referencedColumnName="id")
     *
     * @var Address $delivery_address
     */
    protected $delivery_address;
    
    
    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;
   

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updated_at;
    
    
    /**
     * //@ORM\OneToMany(targetEntity="Contact", mappedBy="customer", cascade={"persist", "remove"}, orphanRemoval=true)
	 * )
     */
    protected $contacts;
    
    /**
     * @var boolean $salutation_modus
     *
     * @ORM\Column(name="salutation_modus", type="boolean", nullable=true)
     */
    protected $salutation_modus;
    
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
    
    public function __toString() {
        
        if (!empty($this->company)) {
            return  sprintf("%s %s - %s", $this->getCustomerType(), $this->getCompany(), $this->getAddress()->getCity());
        } 
        return $this->getFullName() . " - " . $this->getAddress()->getCity();
    }
    
    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    
    /**
     * Get salutation for the customer. Check if company or not!
     */
    public function getSalutation($nl='')
    {
		switch($this->getCustomerType()) {
			case 'Firma':
			case 'Gemeinde':
			case 'Abwassergenossenschaft':
				if ($this->getSalutationModus()) {
					$salutation = sprintf("%s %s", $this->getCustomerType(), $this->getCompany());
				} else {
					$salutation = sprintf("%s %s$nl z.H. %s", $this->getCustomerType(), $this->getCompany(), $this->getFullName());
				}
				break;
			case 'Privat':
				$salutation = $this->getFullName($nl);
				break;
			default:
				if ($this->getSalutationModus()) {
					$salutation = sprintf("%s %s", $this->getCustomerType(), $this->getCompany());
				} else {
					$salutation = sprintf("%s$nl z.H. %s", $this->getCompany(), $this->getFullName());
				}
				break;	
		}
        
        return $salutation;
    }
    
    public function getFullName($nl='') {
        return sprintf("%s$nl %s %s %s", $this->getGender(), $this->getAcademicTitle(), $this->getFirstname(), $this->getLastname());
    }
	
	public function getPostalSalutation($short=false) {
		$pre_gender = ($this->getGender() == 'Herr') ? 'Sehr geehrter' : 'Sehr geehrte';
		$name = $this->getFullName();
		
		if ($short) {
			$name = $this->getGender() . " " . $this->getLastname();
		}
		
		return sprintf("%s %s", $pre_gender, $name);
	}
    
	public function getPhoneNumbers() {
		return sprintf("Tel.: %s <br/>Mob.: %s", $this->getPhone(), $this->getPhoneMobile());
	}
	
	public function getContactsCount() {
		return count($this->getContacts());
	}
	
	public function isCompany() {
		return ($this->customer_type == 'Firma') ? true : false;
	}
	
    // End  Helpers

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
     * Set academic_title
     *
     * @param string $academicTitle
     */
    public function setAcademicTitle($academicTitle)
    {
        $this->academic_title = $academicTitle;
    }

    /**
     * Get academic_title
     *
     * @return string 
     */
    public function getAcademicTitle()
    {
        return $this->academic_title;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set birthday
     *
     * @param date $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * Get birthday
     *
     * @return date 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return ($this->gender == 'Mann') ? 'Herr' : $this->gender;
    }

    /**
     * Set uid_number
     *
     * @param string $uidNumber
     */
    public function setUidNumber($uidNumber)
    {
        $this->uid_number = $uidNumber;
    }

    /**
     * Get uid_number
     *
     * @return string 
     */
    public function getUidNumber()
    {
        return $this->uid_number;
    }

    
    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set updated_from
     *
     * @param BaseUser $updatedFrom
     */
    public function setUpdatedFrom($updatedFrom)
    {
        $this->updated_from = $updatedFrom;
    }

    /**
     * Get updated_from
     *
     * @return BaseUser 
     */
    public function getUpdatedFrom()
    {
        return $this->updated_from;
    }
    
    /**
     * Set Company
     *
     * @param Company $value
     */
    public function setCompanyName($value)
    {
        $this->company = $value;
    }

    /**
     * Get Company
     *
     * @return Company 
     */
    public function getCompanyName()
    {
        return $this->company;
    }
    
    /**
     * Set Address
     *
     * @param Address $value
     */
    public function setOfficeAddress(CustomerAddress $value)
    {
        $this->office_address = $value;
    }

    /**
     * Get Address
     *
     * @return Address 
     */
    public function getOfficeAddress()
    {
        return $this->office_address;
    }
	
	/**
     * Set Address
     *
     * @param Address $value
     */
    public function setDeliveryAddress(CustomerAddress $value)
    {
        $this->delivery_address = $value;
    }

    /**
     * Get Address
     *
     * @return Address 
     */
    public function getDeliveryAddress()
    {
        return $this->delivery_address;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addContact(ContactInterface $contact)
    {
        $this->contacts[] = $contacts;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeContact(ContactInterface $contact)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * {@inheritdoc}
     */
    public function getContacts()
    {
        return $this->contacts;
    }
    
	
    public function setContacts(Collection $contacts)
    {
        die('calling ' . __METHOD__);
        foreach ($this->contacts as $contact) {
            if ($contact->contains($contact)) {
                $contact->removeElement($contact);
            } else {
                $this->removeContact($contact);
            }
        }

        foreach ($contact as $contact) {
            $this->addContact($contact);
        }
    }

    /**
     * Set salutation_modus
     *
     * @param boolean $salutationModus
     * @return Customer
     */
    public function setSalutationModus($salutationModus)
    {
        $this->salutation_modus = $salutationModus;
    
        return $this;
    }

    /**
     * Get salutation_modus
     *
     * @return boolean 
     */
    public function getSalutationModus()
    {
        return $this->salutation_modus;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Customer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phone_mobile
     *
     * @param string $phoneMobile
     * @return Customer
     */
    public function setPhoneMobile($phoneMobile)
    {
        $this->phone_mobile = $phoneMobile;
    
        return $this;
    }

    /**
     * Get phone_mobile
     *
     * @return string 
     */
    public function getPhoneMobile()
    {
        return $this->phone_mobile;
    }

    /**
     * Set customer_type
     *
     * @param string $customerType
     * @return Customer
     */
    public function setCustomerType($customerType)
    {
        $this->customer_type = $customerType;
    
        return $this;
    }

    /**
     * Get customer_type
     *
     * @return string 
     */
    public function getCustomerType()
    {
        return $this->customer_type;
    }
}