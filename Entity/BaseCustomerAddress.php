<?php

namespace IMOControl\M3\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IMOControl\M3\CustomerBundle\Model\CustomerAddress as AbstractCustomerAddress;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class BaseCustomerAddress extends AbstractCustomerAddress
{

}
