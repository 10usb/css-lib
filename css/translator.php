<?php

abstract class CSSTranslator {
	/**
	 * 
	 * @param CSSRuleSet $ruleset
	 * @param string $key
	 * @return mixed
	 */
	public abstract function getValue($ruleset, $key);
	
	/**
	 * 
	 * @param mixed $value
	 * @param string $key
	 * @return boolean
	 */
	public abstract function inherits($value, $key);
}