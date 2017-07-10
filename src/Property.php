<?php
namespace csslib;

class Property {
	private $name;
	private $values;
	
	/**
	 * 
	 * @param string $name
	 * @param string $values
	 */
	public function __construct($name, $value){
		if(!preg_match_all('/(\s(,\s*)?("(([^"]\\"|[^"])+)"|\'(([^\']\\\'|[^\'])+)\'|[^",]+))/is', " $value ", $matches, PREG_SET_ORDER)) throw new \Exception("Invalid property '$value'");
		$this->name = $name;
		
		$this->values = array();
		foreach($matches as $match){
			$this->values[] = new ValueList($match[3]);
		}
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getName(){
		return $this->name;
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
	public function getValueList($index){
		return $this->values[$index];
	}

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		return implode(', ', $this->values);
	}
}