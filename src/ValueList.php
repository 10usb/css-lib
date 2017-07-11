<?php
namespace csslib;

use csslib\values\Value;

class ValueList {
	/**
	 * 
	 * @var \csslib\values\Value[]
	 */
	private $values;
	
	/**
	 * 
	 * @param string $values
	 */
	public function __construct($value){
		if(!preg_match_all('/(\s(".+?"|[^" ,]+))/is', " $value ", $matches, PREG_SET_ORDER)) throw new \Exception("Invalid property '$value'");
		$this->values = array();
		foreach($matches as $match){
			$this->values[] = Value::parse($match[2]);
		}
	}
	
	/**
	 * Return howmany arguments there are
	 * @return number
	 */
	public function getCount(){
		return count($this->values);
	}
	
	/**
	 * Returns the value at the given position
	 * @param CSSValue $index
	 */
	public function getValue($index){
		return $this->values[$index];
	}

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		return implode(' ', $this->values);
	}
}