<?php
namespace csslib;

/**
 * A ruleset contains one of more selectors followed by a set of properties
 * @author 10usb
 */
class RuleSet extends PropertySet {
	/**
	 * All the selections of the rule set
	 * @var \csslib\Selector[]
	 */
	private $selectors;
	
	/**
	 * The index in the document 
	 * @var number
	 */
	private $index;
	
	/**
	 * Constructs an empty ruleset 
	 * @param \csslib\Selector[] $selectors
	 */
	public function __construct($selectors = []){
		parent::__construct();
		$this->selectors	= $selectors;
		$this->index		= -1;
	}
	
	/**
	 * All the selectors in this ruleset
	 * @return \csslib\Selector[]
	 */
	public function getSelectors(){
		return $this->selectors;
	}
	
	/**
	 * To set the index of this ruleset
	 * @param number $index
	 */
	public function setIndex($index){
		$this->index = $index;
	}
	
	/**
	 * Returns the CSS representation
	 * @return string
	 */
	public function __toString(){
		return ($this->selectors ? implode(', ', $this->selectors) : '/* null */').parent::__toString();
	}
}