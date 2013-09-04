<?php
namespace IMOControl\M3\CustomerBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface;
use IMOControl\M3\AdminBundle\Services\Manager as AbstractManager;

class CustomerManager extends AbstractManager implements CustomerManagerInterface
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
		$this->init();
	}
	

	public function init()
	{
		// Create customer root folder if not exists
		$this->uniqueFolder($this->root_path, true);
	}
	
	/**
	 * Set the current customer entity object.
	 *
	 * @return \IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface $object
	 * @throw \InvalidArgumentException If invalid customer object assigned.
	 */
	public function setCustomer(CustomerInterface $object)
	{
		if (!$object instanceof $this->entity_class) {
			throw new \InvalidArgumentException(sprintf("No valid Customer Object. Given: %s Expect instance of %s.", class_name($object), $this->getEntityClass()));
		}
		$this->customer = $object;
	}
	
	/**
	 * Return the current assigned customer entity object.
	 * Notice this property is required to call advanced methods of this class. So be sure
	 * to setCustomer before continue with other actions.
	 *
	 * @return \IMOControl\M3\CustomerBundle\Model\Interfaces\CustomerInterface $customer
	 * @throw \InvalidArgumentException If no customer object is set!
	 */
	public function getCustomer()
	{
		if (!is_null($this->customer)) {
			return $this->customer;
		}
		throw new \InvalidArgumentException("No valid customer available in customer manager! Be sure to call setCustomer first.");
	}
	
	public function create($object)
	{
		$new_name = $this->generateCustomerInternalName(true);
		$object->setInternalName($new_name);
		$this->setCustomer($object);
		if (!$this->createCustomerFolder()) {
    		throw new \RuntimeException(sprintf("Customer folder can't be created at path: %s", $this->manager->getCustomerFolderPath()));
    	}
    	$object->setCreatedFrom($this->getAdminObject()->getCurrentUser());
	}
	
	public function update($object) 
	{
		$this->setCustomer($object);
    	$object->setUpdatedFrom($this->getAdminObject()->getCurrentUser());
    	$this->createCustomerFolder();
    	
    	if ($object->getChangeInternalName()) {
    		$this->renameCustomerFolder();
    	}
		return $object;
	}
	
	
	/**
	 * Generate and return unique internal customer name. This name is also used for the
	 * customer folder. Every document will be placed in that folder.
	 *
	 * Notice: By default if an internal name already exists, it going to be directly returned.
	 * 		   If you wan to refresh it you have to set bool true by calling this method.
	 * 
	 * @param boolean $refresh	Refresh the internal name from given format. Default false
	 * @return string Internal name of the customer.
	 */
	public function generateCustomerInternalName($refresh=false)
	{
		if ($this->getCustomer()->getInternalName() != '' && !$refresh) {
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
            	
            	// Try to call object methods
                $method_name = "get".ucfirst(str_replace('#', '', $value));
            	if (method_exists($customer, $method_name)) {
            		$output = str_replace($value, call_user_func(array($customer, $method_name)), $output);
            		continue;
            	}
            	
            	// Handle mapped objects
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
		return $this->urlify($output);
	}	
	
	/**
	 * Create the customer folder if not empty and folder is unique. 
	 * 
	 * @return boolean Null if internal name is empty. True if folder successfull created.
	 */
	public function createCustomerFolder()
	{
		if ($this->getCustomer()->getInternalName() == '') {
			return null;
		}
		$path = $this->getCustomerFolderPath();
		return $this->uniqueFolder($path, true);
	}
	
	/**
	 * Return the current absolute path of the customer folder.
	 *
	 * @return string
	 */
	public function getCustomerFolderPath()
	{
		return $this->root_path . $this->getCustomer()->getInternalName();
	}
	
	/**
	 * Reneame an existed customer folder with a new one if changed.
	 * On success the new folder path gets written to the customer entity object.
	 *
	 * @ return boolean True if customer folder was modified. False if rename fails. Null  if nothing to change.
	 */
	protected function renameCustomerFolder()
	{
		$old_name = $this->getCustomer()->getInternalName();
		$new_name = $this->generateCustomerInternalName(true);
		$old_path = $this->root_path .  $old_name;
		$new_path = $this->root_path .  $new_name;
			
		if ($old_name != $new_name && is_dir($old_path)) {
			if (rename($old_path, $new_path)) {
				$this->getCustomer()->setInternalName($new_name);
				return true;
			}
			return false;
		}
		return null;
	}
	
	/**
	 * Escape special chars which can make troubles with customer folder 
	 * at filesystem.
	 * 
	 * @param string $name
	 * @return string Escaped value
	 */
	public function urlify($name) 
	{
		$converted = str_replace("ä", "ae", $name);
		$converted = str_replace("Ä", "Ae", $converted);
		$converted = str_replace("ö", "oe", $converted);
		$converted = str_replace("Ö", "Oe", $converted);
		$converted = str_replace("ü", "ue", $converted);
		$converted = str_replace("Ü", "Ue", $converted);
		$converted = str_replace("ß", "ss", $converted);
		$converted = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $converted);
		$converted = trim($converted, '_');
		$converted = preg_replace("/[\/_|+ -]+/", '_', $converted);
		return $converted;
	}
}