<?php
namespace csslib;

class Group {
	private $children;
	
	public function __construct(){
		$this->children	= array();
	}
	
	/**
	 * 
	 * @param CSSRuleSet $ruleset
	 */
	public function createRuleSet($selectors){
		$ruleset = new CSSRuleSet($selectors);
		// TODO index should be determanted by the document.
		$ruleset->setIndex(count($this->children));
		$this->children[] = $ruleset;
		return $ruleset;
	}
	
	/**
	 * 
	 * @return RuleSet[]
	 */
	public function getChildren(){
		return $this->children;
	}
	
}
