<?php

class CSSGroup {
	private $rulesets;
	
	public function __construct(){
		$this->rulesets	= array();
	}
	
	/**
	 * 
	 * @param CSSRuleSet $ruleset
	 */
	public function createRuleSet($selectors){
		$ruleset = new CSSRuleSet($selectors);
		// TODO index should be determanted by the document.
		$ruleset->setIndex(count($this->rulesets));
		$this->rulesets[] = $ruleset;
		return $ruleset;
	}
	
	/**
	 * 
	 * @return array<CSSRuleSet>
	 */
	public function getRuleSets(){
		return $this->rulesets;
	}
	
}
