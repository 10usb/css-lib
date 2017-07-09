<?php
namespace csslib;

/**
 * Psudo class allows storing parsed data for the argument over a plain string
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
	 * 
	 * @param string $name
	 * @param mixed $argument
	 */
	public function __construct($name, $argument = false){
		$this->name		= $name;
		$this->argument	= $argument;
	}
	
	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		if($this->argument){
			return $this->name.'('.$this->argument.')';
		}
		return $this->name;
	}
}