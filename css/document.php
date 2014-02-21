<?php

class CSSDocument {
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

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function format($formatter){
		return $formatter->document($this);
	}

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		return $this->format(CSSDefaultFormatter::getInstance());
	}
}