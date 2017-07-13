<?php
namespace csslib;

/**
 * Represent a single selector of a ruleset
 * @author 10usb
 */
class Selector {
	const T_DESCENDANT			= false;
	const T_CHILD				= '>';
	const T_ADJACENT_SIBLING	= '+';
	const T_GENETAL_SIBLING		= '~';
	
	/**
	 * 
	 * @var \csslib\Selector
	 */
	private $parent;
	
	/**
	 * 
	 * @var string
	 */
	private $type;
	
	/**
	 *
	 * @var string
	 */
	private $tagName;
	
	/**
	 *
	 * @var Attribute[]
	 */
	private $attributes;
	
	/**
	 * 
	 * @var string
	 */
	private $identification;
	
	/**
	 * 
	 * @var string[]
	 */
	private $classes;
	
	/**
	 * 
	 * @var Pseudo[]
	 */
	private $pseudos;
	
	/**
	 * 
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
	private function __construct($parent = null, $type = self::T_DESCENDANT, $id = false, $tagName = false, $classes = false, $attributes = false, $pseudos = false){
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
	 * 
	 * @param string $name
	 * @return \csslib\Selector
	 */
	public function setTagName($name){
		$this->tagName = $name;
		return $this;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getTagName(){
		return $this->tagName;
	}
	
	/**
	 * 
	 * @param string $identification
	 * @return \csslib\Selector
	 */
	public function setIdentification($identification){
		$this->identification = $identification;
		return $this;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getIdentification(){
		return $this->identification;
	}
	
	/**
	 * 
	 * @param string $name
	 * @return \csslib\Selector
	 */
	public function addClass($name){
		$this->classes[] = $name;
		return $this;
	}
	
	/**
	 * 
	 * @return string[]
	 */
	public function getClasses(){
		return $this->classes;
	}
	
	/**
	 *
	 * @param string $name
	 * @param mixed $argument
	 * @return \csslib\Selector
	 */
	public function addAttribute($key, $value, $type = Attribute::T_DEFAULT){
		$this->attributes[] = new Attribute($key, $value, $type);
		return $this;
	}
	
	/**
	 * 
	 * @return \csslib\Attribute[]
	 */
	public function getAttributes(){
		return $this->attributes;
	}
	
	/**
	 * 
	 * @param string $name
	 * @param mixed $argument
	 * @return \csslib\Selector
	 */
	public function addPseudo($name, $argument = false){
		$this->pseudos[] = new Pseudo($name, $argument);
		return $this;
	}
	
	/**
	 * 
	 * @return \csslib\Pseudo[]
	 */
	public function getPseudos(){
		return $this->pseudos;
	}
	
	/**
	 * 
	 * @param string $type
	 * @param string $id
	 * @param string $tagName
	 * @param string[] $classes
	 * @param string[] $pseudos
	 * @return \csslib\Selector
	 */
	public function add($type = false, $identification = false, $tagName = false, $classes = false, $pseudos = false){
		return $this->selector = new self($this, $type, $identification, $tagName, $classes, $pseudos);
	}
	
	/**
	 * 
	 * @param \csslib\Selector $selector
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
	 * 
	 * @return \csslib\Selector
	 */
	public function get(){
		if($this->parent) return $this->parent->get();
		return $this;
	}
	
	/**
	 * Makes a clone of it self
	 */
	public function __clone() {
		if($this->selector){
			$this->selector = clone $this->selector;
			$this->selector->parent = $this;
		}
	}

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		$css = '';
		if($this->type){
			$css.= $this->type.' ';
		}
		if(!$this->tagName && !$this->identification && !$this->classes && !$this->pseudos){
			$css.= '*';
		}else{
			if($this->tagName){
				$css.= $this->tagName;
			}
			if($this->attributes){
				$css.= implode('', $this->attributes);
			}
			if($this->identification){
				$css.= '#'.$this->identification;
			}
			if($this->classes){
				$css.= '.'.implode('.', $this->classes);
			}
			if($this->pseudos){
				$css.= ':'.implode(':', $this->pseudos);
			}
			if($this->selector){
				$css.= ' '.$this->selector;
			}
		}
		return $css;
	}
	
	/**
	 * 
	 * @param string $type
	 * @return \csslib\Selector
	 */
	public static function create($type = false){
		return new self(null, $type);
	}
}