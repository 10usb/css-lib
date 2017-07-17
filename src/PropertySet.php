<?php
namespace csslib;

/**
 * Base class for any block type that has properties
 * @author 10usb
 */
class PropertySet {
	/**
	 * 
	 * @var Property[]
	 */
	private $properties;
	
	public function __construct(){
		$this->properties	= [];
	}
	
	/**
	 * 
	 * @param string $key
	 * @param string $value
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
	 * 
	 * @param string $key
	 * @return \csslib\Property|boolean
	 */
	public function getProperty($key){
		foreach($this->properties as $property){
			if($property->getName()==$key){
				return $property;
			}
		}
		return false;
	}
	
	/**
	 * 
	 * @return \csslib\Property[]
	 */
	public function getProperties(){
		return $this->properties;
	}
	
	
	/**
	 * Returns the CSS
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