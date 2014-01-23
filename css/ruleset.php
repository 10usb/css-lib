<?php

class CSSRuleSet {
	private $selectors;
	private $index;
	private $properties;
	
	
	public function __construct($selectors = array()){
		$this->selectors	= $selectors;
		$this->index		= -1;
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
	 * 
	 * @param number $index
	 */
	public function setIndex($index){
		$this->index = $index;
	}
	
	/**
	 * 
	 * @param CSSSelector $path
	 * @return array<CSSMatch>
	 */
	public function match($path){
		$matches = array();
		foreach($this->selectors as $selector){
			if($selector->match($path)){
				$matches[] = new CSSMatch($selector, $this, $this->index);
			}
		}
		return $matches;
	}
	
	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		$css = ($this->selectors ? implode(', ', $this->selectors) : '/* null */')." {\n";
		foreach($this->properties as $key=>$value){
			$css.= "  $key: $value;\n";
		}
		$css.= "}\n";
		return $css;
	}
}