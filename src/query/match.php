<?php

class CSSMatch {
	private $selector;
	private $ruleset;
	private $specificity;
	
	public function __construct($selector, $ruleset, $index){
		$this->selector			= $selector;
		$this->ruleset			= $ruleset;
		$this->specificity		= $selector->getSpecificity(new CSSSpecificity());
		$this->specificity->i	= $index;
	}
	
	/**
	 * 
	 * @return CSSRuleSet
	 */
	public function getRuleSet(){
		return $this->ruleset;
	}

	/**
	 *
	 * @param CSSMatch $a
	 * @param CSSMatch $b
	 */
	public static function compare($a, $b){
		if($a->specificity->a != $b->specificity->a){
			return $a->specificity->a < $b->specificity->a ? -1 : 1;
		}
		if($a->specificity->b != $b->specificity->b){
			return $a->specificity->b < $b->specificity->b ? -1 : 1;
		}
		if($a->specificity->c != $b->specificity->c){
			return $a->specificity->c < $b->specificity->c ? -1 : 1;
		}
		if($a->specificity->i != $b->specificity->i){
			return $a->specificity->i < $b->specificity->i ? -1 : 1;
		}
		return 0;
	}
}