<?php
namespace IMOControl\M3\CustomerBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface;
use IMOControl\M3\AdminBundle\Services\Manager as AbstractManager;

class CustomerManager extends AbstractManager
{
	/**
	 * Holds the absolute path of the filesystem where the new customers folder will be created.
	 * @var string $customer_root_path
	 */
	protected $customer_root_path;
	
	
	/**
	 * Entity object of the customer.
	 * 
	 * @var IMOControl\M3\CustomerBundle\Interfaces\CustomerInterface $customer
	 */
	protected $customer;
	
	public function __construct($entity_class, $customer_root_path)
	{
		if (is_dir($customer_root_path) && is_writable($customer_root_path)) { 
			$this->root_path = $customer_root_path;
		} else {
			throw new \InvalidArgumentException(sprintf("The path %s doesn't exists or is not writeable", $customer_root_path));
		}
		parent::__construct($entity_class);
	}
	

	public function init() {
		// Create customer root folder if not exists
		$this->uniqueFolder($this->root_path, true);
	}
	
	public function setCustomer(CustomerInterface $object)
	{
		if (!$object instanceof $this->entity_class) {
			throw new \InvalidArgumentException(sprintf("No valid Customer Object given. Given: %s Expected instance of %s.", var_dump($object), $this->getEntityClass()));
		}
		
		$this->customer = $object;
	}
	
	public function getCustomer()
	{
		if (!is_null($this->customer)) {
			return $this->customer;
		} else {
			die('new customer class ...');
			return $this->customer = new $this->entity_class();
		}
	}
	
	public function generateCustomerInternalName($refresh=false)
	{
		if ($this->getCustomer()->getInternalName() !== '' && !$refresh) {
			return $this->getCustomer()->getInternalName();
		}
		
		// Generate new unique internal customer name
		$customer = $this->getCustomer();
		$format = $this->getOption('folder_format');
		$min_length = (int) $this->getOption('folder_id_length');
		$id = $customer->getId();
		$output = $format;
		
		if ($min_length > 0 && $min_length > strlen($id)) {
    		$id = sprintf('%0' . $min_length . 's', $id);
		}
		
		preg_match_all("/(?<pholders>(\#+\w+\#))/", $format, $matches);
        if (array_key_exists('pholders', $matches)) {
            foreach($matches['pholders'] as $key => $value) {
            	if (strtolower($value) == '#id#') {
            		$output = str_replace('#Id#', $id, $output);
					$output = str_replace('#id#', $id, $output);
            		continue;
            	}
            
                $method_name = "get".ucfirst(str_replace('#', '', $value));
            	if (method_exists($customer, $method_name)) {
            		$output = str_replace($value, call_user_func(array($customer, $method_name)), $output);
            		continue;
            	}
            	
            	// Handle objects
            	$exp = explode('__', str_replace('#', '', $value));
            	if (count($exp) == 2) {
            		$parent_object = "get".ucfirst($exp[0]);
            		if (method_exists($customer, $parent_object)) {
            			$obj = call_user_func(array($customer, $parent_object));
            			$method_name = "get".ucfirst($exp[1]);
            			if (method_exists($obj, $method_name)) {
            				$output = str_replace($value, call_user_func(array($obj, $method_name)), $output);
            				continue;
            			}
            		}
            	}
            }
            $output = str_replace('__', '_', $output);
        }
		return $output;
	}	
	
	
	public function createCustomerFolder()
	{
		if ($this->getCustomer()->getInternalName() == '') {
			return null;
		}
		$path = $this->root_path . $this->getCustomer()->getInternalName();
		return $this->uniqueFolder($path, true);
		
	}
}