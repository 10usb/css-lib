<?php
namespace csslib;

use csslib\values\Value;

/**
 * Every property can contain 1 or more value list, that may contain 1 or more values
 * @author 10usb
 */
class ValueList {
	/**
	 * 
	 * @var \csslib\values\Value[]
	 */
	private $values;
	
	/**
	 * Construct a values list from a string representation of values
	 * @param string $value
	 */
	public function __construct($value){
		if(!preg_match_all('/(\s(".+?"|[^" ,]+))/is', " $value ", $matches, PREG_SET_ORDER)) throw new \Exception("Invalid property '$value'");
		$this->values = array();
		foreach($matches as $match){
			$this->values[] = Value::parse($match[2]);
		}
	}
	
	/**
	 * Return how many values there are in the lisst
	 * @return number
	 */
	public function getCount(){
		return count($this->values);
	}
	
	/**
	 * Returns the value at the given index
	 * @param \csslib\values\Value $index
	 */
	public function getValue($index){
		return $this->values[$index];
	}

	/**
	 * Returns the CSS representation
	 * @return string
	 */
	public function __toString(){
		return implode(' ', $this->values);
	}
}