<?php
namespace csslib;

/**
 * Represent a property within a propertyset consisting of an name and an list of values 
 * @author 10usb
 */
class Property {
	/**
	 * Name of the property
	 * @var string
	 */
	private $name;
	
	/**
	 * Array of value lists
	 * @var ValueList[]
	 */
	private $values;
	
	/**
	 * Constructs a property and parses the string value into value list objects
	 * @param string $name Name of the property
	 * @param string $value Valid string of values
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
	 * Name of the property
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Return how many value lists there are
	 * @return number
	 */
	public function getCount(){
		return count($this->values);
	}
	
	/**
	 * Returns the value list at the given position
	 * @param integer $index Index to get
	 * @return \csslib\ValueList
	 */
	public function getValueList($index){
		return $this->values[$index];
	}

	/**
	 * Returns the CSS representation
	 * @return string
	 */
	public function __toString(){
		return $this->name.': '.implode(', ', $this->values).';';
	}
}