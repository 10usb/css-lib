<?php
namespace csslib;

class RuleSet extends PropertySet {
	/**
	 * 
	 * @var \csslib\Selector[]
	 */
	private $selectors;
	
	/**
	 * 
	 * @var number
	 */
	private $index;
	
	/**
	 * 
	 * @param \csslib\Selector[] $selectors
	 */
	public function __construct($selectors = []){
		parent::__construct();
		$this->selectors	= $selectors;
		$this->index		= -1;
	}
	
	/**
	 * 
	 * @return \csslib\Selector[]
	 */
	public function getSelectors(){
		return $this->selectors;
	}
	
	/**
	 * 
	 * @param number $index
	 */
	public function setIndex($index){
		$this->index = $index;
	}
	
	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		return ($this->selectors ? implode(', ', $this->selectors) : '/* null */').parent::__toString();
	}
}