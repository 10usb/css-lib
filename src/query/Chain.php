<?php
namespace csslib\query;

use csslib\PropertySet;

class Chain extends PropertySet {
	/**
	 * 
	 * @var \csslib\query\Chain
	 */
	private $parent;
	
	/**
	 * 
	 * @param \csslib\Selector[] $selectors
	 */
	public function __construct($parent){
		parent::__construct();
		$this->parent	= $parent;
	}
	
	/**
	 * 
	 * @return \csslib\query\Chain
	 */
	public function getParent(){
		return $this->parent;
	}
}