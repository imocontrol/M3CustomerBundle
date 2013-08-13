<?php

namespace IMOControl\M3\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IMOControl\M3\CustomerBundle\Model\CustomerAddress as AbstractCustomerAddress;

/**
 * Address
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class BaseCustomerAddress extends AbstractCustomerAddress
{
	
}
