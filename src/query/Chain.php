<?php
namespace csslib\query;

use csslib\PropertySet;

/**
 * When building a path a chain of property sets of the matching properties are stores in the class
 * @author 10usb
 */
class Chain extends PropertySet {
	/**
	 * 
	 * @var \csslib\query\Chain
	 */
	private $parent;
	
	/**
	 * Constructs a instance of a chain
	 * @param \csslib\Selector[] $selectors
	 */
	public function __construct($parent){
		parent::__construct();
		$this->parent	= $parent;
	}
	
	/**
	 * Returns the parent of this part in the chain
	 * @return \csslib\query\Chain
	 */
	public function getParent(){
		return $this->parent;
	}
}