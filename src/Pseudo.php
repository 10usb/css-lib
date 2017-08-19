<?php
namespace csslib;

/**
 * Pseudo class allows storing parsed data for the argument over a plain string
 * @author 10usb
 */
class Pseudo {
	/**
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * 
	 * @var mixed
	 */
	private $argument;
	
	/**
	 * Construct an pseudo class instance
	 * @param string $name Name of the class
	 * @param mixed $argument Argument to the pseudo class
	 */
	public function __construct($name, $argument = false){
		$this->name		= $name;
		$this->argument	= $argument;
	}
	
	/**
	 * Returns the CSS representation
	 * @return string
	 */
	public function __toString(){
		if($this->argument){
			return $this->name.'('.$this->argument.')';
		}
		return $this->name;
	}
}