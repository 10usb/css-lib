<?php
namespace csslib;

class PropertySet {
	private $properties;
	
	public function __construct(){
		$this->properties	= array();
	}
	
	/**
	 * 
	 * @param string $key
	 * @param string $value
	 */
	public function setProperty($key, $value){
		if($value instanceof CSSProperty){
			$this->properties[$key] = $value;
		}else{
			$this->properties[$key] = new CSSProperty($value);
		}
	}
	
	/**
	 * 
	 * @param string $key
	 * @return CSSProperty
	 */
	public function getProperty($key){
		if(isset($this->properties[$key])) return $this->properties[$key];
		return false;
	}
	
	/**
	 * 
	 * @return array<string>
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
			$css.= "  $key: $value;\n";
		}
		$css.= "}\n";
		return $css;
	}
	
}