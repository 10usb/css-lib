<?php
namespace csslib\query;

/**
 * 
 * @author 10usb
 */
interface Translator {
	/**
	 * 
	 * @param string $key
	 * @param CSSProperty $value
	 * @param CSSRuleSet $ruleset
	 * @return mixed
	 */
	public function translate($key, $value, $ruleset);
	/**
	 * 
	 * @param CSSRuleSet $ruleset
	 * @param string $key
	 * @return mixed
	 */
	public function getValue($ruleset, $key);
	
	/**
	 * 
	 * @param mixed $value
	 * @param string $key
	 * @return boolean
	 */
	public function inherits($value, $key);
}