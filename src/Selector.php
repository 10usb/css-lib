<?php
namespace csslib;

use csslib\formatters\Pretty;

/**
 * Represent a single selector of a ruleset or a subpart of a selector
 * @author 10usb
 */
class Selector {
	/**
	 * The matching parent selector should be an ascendant of this matching selector
	 * @var string T_DESCENDANT
	 */
	const T_DESCENDANT			= false;
	
	/**
	 * The matching parent selector should be a direct ascendant of this matching selector
	 * @var string T_CHILD
	 */
	const T_CHILD				= '>';
	
	/**
	 * The matching parent selector should be a direct preceding sibling
	 * @var string T_ADJACENT_SIBLING
	 */
	const T_ADJACENT_SIBLING	= '+';
	
	/**
	 * The matching parent selector should be any preceding sibling
	 * @var string T_GENERAL_SIBLING
	 */
	const T_GENERAL_SIBLING		= '~';
	
	/**
	 * The parent of this selector part
	 * @var \csslib\Selector
	 */
	private $parent;
	
	/**
	 * Type of relation this selector has to its parent
	 * @var string
	 */
	private $type;
	
	/**
	 *	Tagname to match
	 * @var string
	 */
	private $tagName;
	
	/**
	 * Attributes to match
	 * @var Attribute[]
	 */
	private $attributes;
	
	/**
	 * Identification to match
	 * @var string
	 */
	private $identification;
	
	/**
	 * Classes to match
	 * @var string[]
	 */
	private $classes;
	
	/**
	 * Pseudo classes to match
	 * @var Pseudo[]
	 */
	private $pseudos;
	
	/**
	 * Child selector
	 * @var \csslib\Selector
	 */
	private $selector;
	
	/**
	 * 
	 * @param string $type
	 * @param string $id
	 * @param string $tagName
	 * @param string[] $classes
	 * @param string[] $pseudos
	 */
	private function __construct($parent = null, $type = self::T_DESCENDANT, $identification = false, $tagName = false, $classes = false, $attributes = false, $pseudos = false){
		$this->parent			= $parent;
		$this->type				= $type;
		$this->identification	= $identification;
		$this->tagName			= $tagName;
		$this->classes			= $classes ? $classes : [];
		$this->attributes		= $attributes? $attributes: [];
		$this->pseudos			= $pseudos ? $pseudos : [];
		$this->selector			= null;
	}
	
	/**
	 * Returns the type of this selector
	 * @return string|boolean
	 */
	public function getType(){
		return $this->type;
	}
	
	/**
	 * Sets the tag name to match
	 * @param string $name Name of the tag
	 * @return \csslib\Selector
	 */
	public function setTagName($name){
		$this->tagName = $name;
		return $this;
	}
	
	/**
	 * Returns the tagname to match
	 * @return string|boolean
	 */
	public function getTagName(){
		return $this->tagName;
	}
	
	/**
	 * Sets the identification to match
	 * @param string $identification
	 * @return \csslib\Selector
	 */
	public function setIdentification($identification){
		$this->identification = $identification;
		return $this;
	}
	
	/**
	 * Returns the identification to match
	 * @return string|boolean
	 */
	public function getIdentification(){
		return $this->identification;
	}
	
	/**
	 * Append a classname to match
	 * @param string $name Name of the class
	 * @return \csslib\Selector
	 */
	public function addClass($name){
		$this->classes[] = $name;
		return $this;
	}
	
	/**
	 * Returns an array of classes
	 * @return string[]
	 */
	public function getClasses(){
		return $this->classes;
	}
	
	/**
	 * Append an attributes to match
	 * @param string $name Name of the attribute
	 * @param string $value Value to match
	 * @param string $type Type of matching to use
	 * @return \csslib\Selector
	 */
	public function addAttribute($key, $value, $type = Attribute::T_DEFAULT){
		$this->attributes[] = new Attribute($key, $value, $type);
		return $this;
	}
	
	/**
	 * Returns an array of attributes
	 * @return \csslib\Attribute[]
	 */
	public function getAttributes(){
		return $this->attributes;
	}
	
	/**
	 * Append an pseudo class to match 
	 * @param string $name Name of the pseudo class
	 * @param mixed $argument Argument of the pseudo class
	 * @return \csslib\Selector
	 */
	public function addPseudo($name, $argument = false){
		$this->pseudos[] = new Pseudo($name, $argument);
		return $this;
	}
	
	/**
	 * Returns an array of the pseudo classes to match
	 * @return \csslib\Pseudo[]
	 */
	public function getPseudos(){
		return $this->pseudos;
	}
	
	/**
	 * Creates an sets the child selector
	 * @param string $type Type of the selector
	 * @param string $identification Identification to match (#example)
	 * @param string $tagName Tagname to match (example)
	 * @param string[] $classes Classname to match (.example)
	 * @param string[] $pseudos Pseudo classes to match (:example)
	 * @return \csslib\Selector
	 */
	public function add($type = false, $identification = false, $tagName = false, $classes = false, $pseudos = false){
		return $this->selector = new self($this, $type, $identification, $tagName, $classes, $pseudos);
	}
	
	/**
	 * Append the selector(s) to this selector
	 * @param \csslib\Selector $selector Selector to be appended
	 * @param string $type
	 */
	public function append($selector, $type){
		$this->selector			= clone $selector;
		$this->selector->parent	= $this;
		$this->selector->type	= $type;
		
		return $this->selector;
	}
	
	/**
	 * Returns the next element in this selector chain
	 * @return \csslib\Selector
	 */
	public function hasNext(){
		return !!$this->selector;
	}
	
	/**
	 * Returns the next element in this selector chain
	 * @return \csslib\Selector
	 */
	public function getNext(){
		return $this->selector;
	}
	
	/**
	 * Returns the last selector in the chain
	 * @return \csslib\Selector
	 */
	public function getEnd(){
		if($this->selector) return $this->selector->getEnd();
		return $this;
	}
	
	/**
	 * Returns the first selector in the chain
	 * @return \csslib\Selector
	 */
	public function get(){
		if($this->parent) return $this->parent->get();
		return $this;
	}
	
	/**
	 * Returns the parent of this selector part
	 * @return \csslib\Selector
	 */
	public function getParent(){
		return $this->parent;
	}
	
	/**
	 * Let the clone wars begin
	 */
	public function __clone() {
		if($this->selector){
			$this->selector = clone $this->selector;
			$this->selector->parent = $this;
		}
	}
	
	/**
	 * Returns the CSS representation
	 * @return string
	 */
	public function __toString(){
		return Pretty::selector($this);
	}
	
	/**
	 * Used to create a selector instance
	 * @param string $type Type of the selector
	 * @return \csslib\Selector
	 */
	public static function create($type = false){
		return new self(null, $type);
	}
}