<?php
namespace csslib\values;

/**
 * Base class for al values in css 
 * @author 10usb
 */
abstract class Value {
	/**
	 * 
	 * @var string
	 */
	protected $value;
	
	/**
	 * 
	 * @param unknown $value
	 * @throws Exception
	 * @return \csslib\values\Value
	 */
	public static function parse($value){
		if(preg_match(Name::PATTERN, $value)) return new Name($value);
		if(preg_match(Text::PATTERN, $value)) return new Text($value);
		if(preg_match(Color::PATTERN, $value)) return new Color($value);
		if(preg_match(Measurement::PATTERN, $value)) return new Measurement($value);
		
		throw new \Exception("Invalid Value '$value'");
	}
	
	/**
	 * 
	 * @param string $value
	 */
	private function __construct($value){
		$this->value = $value;
		$this->init();
	}
	
	/**
	 * Empty init function
	 */
	protected function init(){}
	
	/**
	 * Returns the translated value
	 * @param string $value
	 * @param string $unit
	 * @param boolean $throw
	 * @throws Exception
	 * @return boolean
	 */
	public function getMeasurement($unit, $value = null, $throw = true){
		if($throw) throw new \Exception("Invalid Value '$this->value'");
		return false;
	}
	
	/**
	 * Return the name
	 * @param boolean $throw
	 * @throws Exception
	 * @return boolean
	 */
	public function getName($throw = true){
		if($throw) throw new \Exception("Invalid Value '$this->value'");
		return false;
	}
	
	/**
	 * Return true if the value is a color
	 * @return boolean
	 */
	public function isColor(){
		return false;
	}
	
	/**
	 * The red value
	 * @param boolean $throw
	 * @throws Exception
	 * @return boolean
	 */
	public function getRed($throw = true){
		if($throw) throw new \Exception("Invalid Value '$this->value'");
	}
	
	/**
	 * The green value
	 * @param boolean $throw
	 * @throws Exception
	 * @return boolean
	 */
	public function getGreen($throw = true){
		if($throw) throw new \Exception("Invalid Value '$this->value'");
		return false;
	}
	
	/**
	 * The blue value
	 * @param boolean $throw
	 * @throws Exception
	 * @return boolean
	 */
	public function getBlue($throw = true){
		if($throw) throw new \Exception("Invalid Value '$this->value'");
		return false;
	}

	/**
	 * String value or name
	 * @param boolean $throw
	 * @throws Exception
	 * @return boolean
	 */
	public function getText($throw = true){
		if($throw) throw new \Exception("Invalid Value '$this->value'");
		return false;
	}

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		return $this->value;
	}
}