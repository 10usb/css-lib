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
	 * @param string $identification
	 * @return \csslib\Selector
	 */
	public function setIdentification($identification){
		$this->identification = $identification;
		return $this;
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
	 * @return \csslib\Selector
	 */
	public function get(){
		if($this->parent) return $this->parent->get();
		return $this;
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