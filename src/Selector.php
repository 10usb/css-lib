<?php
namespace csslib;

class Selector {
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
	private $identification;
	
	/**
	 * 
	 * @var string
	 */
	private $tagName;
	
	/**
	 * 
	 * @var string[]
	 */
	private $classes;
	
	/**
	 * 
	 * @var string[]
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
	public function __construct($parent = null, $type = false, $id = false, $tagName = false, $classes = false, $pseudos = false){
		$this->parent			= $parent;
		$this->type				= $type;
		$this->identification	= $identification;
		$this->tagName			= $tagName;
		$this->classes			= $classes ? $classes : [];
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
		$this->identification= $identification;
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
	 * 
	 * @param CSSSelector $path
	 * @deprecated should be located in a query class or something
	 */
	public function match($path){
		$current = $path;

		if($this->type=='>'){
			if(!$this->matches($path)) return false;
			
			if($path->selector==null){
				return $this->selector==null;
			}
			if($this->selector==null) return false;
			
			return $this->selector->match($path->selector);
		}
		
		$match = false;
		while($current!=null){
			if($this->matches($current)){
				$match = true;
				break;
			}
			$current = $current->selector;
		}
		if($current==null) return false;
		
		if($current->selector==null){
			return $this->selector==null;
		}
		if($this->selector==null) return false;

		return $this->selector->match($current->selector);
	}
	
	/**
	 * 
	 * @param CSSSelector $other
	 * @deprecated should be located in a query class or something
	 */
	public function matches($other){
		if($this->tagName && $this->tagName!=$other->tagName) return false;
		if($this->classes && count(array_intersect($this->classes, $other->classes))!=count($this->classes)) return false;
		if($this->pseudos && count(array_intersect($this->pseudos, $other->pseudos))!=count($this->pseudos)) return false;
		return true;
	}
	
	/**
	 * 
	 * @param Specificity $specificity
	 */
	public function getSpecificity($specificity){
		if($this->identification)	$specificity->a++;
		if($this->classes)			$specificity->b+=count($this->classes);
		if($this->tagName)			$specificity->c++;
		if($this->pseudos)			$specificity->c+=count($this->pseudos);
		
		if($this->selector!=null) return $this->selector->getSpecificity($specificity);
		return $specificity;
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