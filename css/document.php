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
	 * @param CSSSelector $path
	 */
	public function match($path){
		$matches = array();
		foreach($this->rulesets as $ruleset){
			$matches = array_merge($matches, $ruleset->match($path));
		}
		
		usort($matches, array('CSSMatch', 'compare'));
		$result = new CSSRuleSet();
		foreach($matches as $match){
			foreach($match->getRuleSet()->getProperties() as $key=>$value){
				$result->setProperty($key, $value);
			}
		}
		return $result;
	}

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		$css = '';
		foreach($this->rulesets as $ruleset){
			$css.= $ruleset."\n";
		}
		return $css;
	}
}