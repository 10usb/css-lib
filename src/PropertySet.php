<?php
namespace csslib;

/**
 * Base class for any block type that has properties
 * @author 10usb
 */
abstract class PropertySet {
	/**
	 * Array of al properties in this property set
	 * @var Property[]
	 */
	private $properties;
	
	/**
	 * Initializes the internal variables
	 */
	public function __construct(){
		$this->properties	= [];
	}
	
	/**
	 * Appending a property at the end and cleaning up any property with the same name
	 * @param string $key Name of the property
	 * @param string $value String representation of the values
	 */
	public function setProperty($key, $value = null){
		if($key instanceof Property){
			$value	= $key;
			$key	= $key->getName();
		}elseif(!$value instanceof Property){
			$value	= new Property($key, $value);
		}
		
		foreach($this->properties as $index=>$property){
			if($property->getName() == $key){
				unset($this->properties[$index]);
			}
		}
		
		$this->properties[] = $value;
		return $this;
	}
	
	/**
	 * Return the property if it is within this set otherwise retuns false
	 * @param string|string[] $key Name or array of names of the property to obtain
	 * @param string|bool $match Name of the matched property
	 * @return \csslib\Property|boolean
	 */
	public function getProperty($key, &$match = false){
		if(is_array($key)){
			foreach(array_reverse($this->properties) as $property){
				if(in_array($property->getName(), $key)){
					$match = $property->getName();
					return $property;
				}
			}
		}else{
			foreach(array_reverse($this->properties) as $property){
				if($property->getName()==$key){
					$match = $key;
					return $property;
				}
			}
		}
		return false;
	}
	
	/**
	 * Returns an array of all properties in this set
	 * @return \csslib\Property[]
	 */
	public function getProperties(){
		return $this->properties;
	}
	
	
	/**
	 * Returns the CSS representation
	 * @return string
	 */
	public function __toString(){
		$css = " {\n";
		foreach($this->properties as $key=>$value){
			$css.= "  $value\n";
		}
		$css.= "}\n";
		return $css;
	}
	
}