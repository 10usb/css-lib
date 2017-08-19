<?php
namespace csslib\values;

/**
 * Represents a hex color value
 * @author 10usb
 */

class Color extends Value {
	/**
	 * Regex pattern to validate a color value
	 * @var string PATTERN
	 */
	const PATTERN = '/^(\#([0-9a-f]{3}|[0-9a-f]{6}))$/is';
	
	/**
	 * The values of the color
	 * @var number $red
	 * @var number $green
	 * @var number $blue
	 */
	private $red, $green, $blue;

	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::init()
	 */
	protected function init(){
		if(preg_match('/^\#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/is', strtolower($this->value), $matches)){
			$this->red		= hexdec($matches[1]);
			$this->green	= hexdec($matches[2]);
			$this->blue		= hexdec($matches[3]);
		}elseif(preg_match('/^\#([0-9a-f])([0-9a-f])([0-9a-f])$/is', strtolower($this->value), $matches)){
			$this->red		= hexdec($matches[1].$matches[1]);
			$this->green	= hexdec($matches[2].$matches[2]);
			$this->blue		= hexdec($matches[3].$matches[3]);
		}else{
			throw new \Exception("Invalid color value '$this->value'");
		}
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::isColor()
	 */
	public function isColor(){
		return true;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::getRed()
	 */
	public function getRed($throw = true){
		return $this->red;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::getGreen()
	 */
	public function getGreen($throw = true){
		return $this->green;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::getBlue()
	 */
	public function getBlue($throw = true){
		return $this->blue;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::__toString()
	 */
	public function __toString(){
		return sprintf('#%02X%02X%02X', $this->red, $this->green, $this->blue);
	}
}