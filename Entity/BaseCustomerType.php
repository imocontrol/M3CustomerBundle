<?php
namespace IMOControl\M3\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;

use IMOControl\M3\CustomerBundle\Model\CustomerType as AbstractCustomerType;

/**
 * @ORM\MappedSuperclass
 */
class BaseCustomerType extends AbstractCustomerType
{
    
}