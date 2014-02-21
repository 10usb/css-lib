<?php

class CSSRuleSet extends CSSPropertySet {
	private $selectors;
	private $index;
	
	
	public function __construct($selectors = array()){
		$this->selectors	= $selectors;
		$this->index		= -1;
		parent::__construct();
	}
	
	/**
	 * 
	 * @return array<string>
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
	 * 
	 * @param CSSSelector $path
	 * @return array<CSSMatch>
	 */
	public function match($path){
		$matches = array();
		foreach($this->selectors as $selector){
			if($selector->match($path)){
				$matches[] = new CSSMatch($selector, $this, $this->index);
			}
		}
		return $matches;
	}
	
	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		return ($this->selectors ? implode(', ', $this->selectors) : '/* null */').parent::__toString();
	}
}