<?php
namespace csslib;

/**
 * Psudo class allows storing parsed data for the argument over a plain string
 * @author 10usb
 */
class Attribute {
	const T_DEFAULT		= '';
	const T_IN			= '~';
	const T_FIRST		= '|';
	const T_BEGINS		= '^';
	const T_ENDS		= '$';
	const T_CONTAINS	= '*';
	
	/**
	 *
	 * @var string
	 */
	private $key;
	
	/**
	 *
	 * @var string
	 */
	private $value;
	
	/**
	 * 
	 * @var string
	 */
	private $type;
	
	/**
	 * 
	 * @param string $name
	 * @param mixed $argument
	 */
	public function __construct($key, $value, $type){
		$this->key		= $key;
		$this->value	= $value;
		$this->type		= $type;
	}
	
	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		if($this->value || $this->type) return '['.$this->key.$this->type.'="'.str_replace('"', '\"', $this->value).'"]';
		return '['.$this->key.']';
	}
}