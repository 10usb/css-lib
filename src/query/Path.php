<?php
namespace csslib\query;

use csslib\Selector;
use csslib\PropertySet;
use csslib\formatters\Pretty;

class Path {
	/**
	 * 
	 * @var \csslib\Document
	 */
	private $document;
	
	/**
	 * 
	 * @var \csslib\query\Translator
	 */
	private $translator;
	
	/**
	 * 
	 * @var array[]
	 */
	private $stack;
	
	/**
	 * 
	 * @var integer
	 */
	private $depth;
	
	/**
	 *
	 * @var \csslib\query\Chain
	 */
	private $current;
	
	/**
	 *
	 * @var boolean
	 */
	private $loaded;
	
	
	/**
	 * 
	 * @param \csslib\Document $document
	 * @param \csslib\query\Translator $translator
	 */
	public function __construct($document, $translator){
		$this->document		= $document;
		$this->translator	= $translator;
		$this->depth		= 0;
		$this->stack		= [];
		$this->current		= null;
		$this->loaded		= false;
	}
	
	/**
	 * 
	 * @param string $key
	 * @return mixed
	 */
	public function getValue($key){
		$this->loadCurrent();
		
		return $this->translator->getValue($this->current, $this->document, $key);
	}
	
	/**
	 * 
	 * @return \csslib\Selector
	 */
	public function push(){
		if($this->depth > 0){
			// Make sure the parent is loaded before creating a new one
			$this->loadCurrent();
			// Now set loaded back to false as the new one isn't
			$this->loaded = false;
		}
		
		$selector = Selector::create();
		
		if(count($this->stack) > $this->depth){
			$this->stack[$this->depth][] = $selector;
		}else{
			$this->stack[] = [$selector];
		}
		$this->depth++;
		
		return $selector;
	}
	
	/**
	 * 
	 */
	public function pop(){
		if(count($this->stack) > $this->depth) array_pop($this->stack);
		if($this->depth==0) throw new \Exception('Can\' pop nothing');
		$this->depth--;
		
		if($this->current != null){
			$this->current	= $this->current->getParent();
			$this->loaded	= $this->current != null;
		}
	}
	
	/**
	 * 
	 */
	private function loadCurrent(){
		if(!$this->loaded){
			$matches = [];
			$walker = new Walker($this->document, $this->translator);
			foreach($walker as $index=>$ruleSet){
				$this->match($matches, $ruleSet, $index);
			}
			
			usort($matches, function($a, $b){
				return Specificity::compare($a[0], $b[0]);
			});
			
			$propertySet = new Chain($this->current);
			foreach ($matches as $match){
				foreach($match[1]->getProperties() as $property){
					$propertySet->setProperty($property);
				}
			}
			
			$this->current	= $propertySet;
			$this->loaded	= true;
		}
	}
	
	/**
	 * 
	 * @param array $matches
	 * @param \csslib\RuleSet $ruleSet
	 * @param integer $index
	 * @return boolean
	 */
	private function match(&$matches, $ruleSet, $index){
		$specificities = [];
		foreach($ruleSet->getSelectors() as $selector){
			if($this->isMatch($selector)){
				$specificities[] = Specificity::get($selector);
			}
		}
		
		if(!$specificities) return false;
		
		usort($specificities, [Specificity::class, 'compare']);
		$specificity = end($specificities);
		$specificity->setIndex($index);
		
		$matches[] = [$specificity, $ruleSet];
		return true;
	}
	
	/**
	 * TODO make this function real ^^
	 * @param \csslib\Selector $selector
	 * @return boolean
	 */
	public function isMatch($selector){
		return $this->isMatchingTail($selector->getEnd(), $this->depth - 1, count($this->stack[$this->depth - 1]) - 1);
	}
	
	/**
	 * 
	 * @param csslib\Selector $selector
	 * @param integer $depth
	 * @param integer $offset
	 * @return boolean
	 */
	private function isMatchingTail($selector, $depth, $offset){
		$target = $this->stack[$depth][$offset];
		
		if($selector->getTagName() && $selector->getTagName()!='*' && $target->getTagName()!=$selector->getTagName()) return false;
		if($selector->getIdentification() && $target->getIdentification()!=$selector->getIdentification()) return false;
		if($selector->getPseudos()){
			foreach($selector->getPseudos() as $pseudo){
				$has = false;
				foreach($target->getPseudos() as $other){
					if("$pseudo" == "$other") $has = true;
				}
				if(!$has) return false;
			}
		}
		if($selector->getClasses()){
			if(count(array_intersect($selector->getClasses(), $target->getClasses())) != count($selector->getClasses())) return false;
		}
		
		switch($selector->getType()){
			case Selector::T_CHILD:
				// Is parent matching
				if(!$selector->getParent() || $depth <= 0) throw new \Exception('No parent when type expects parent');
				if($this->isMatchingTail($selector->getParent(), $depth - 1, count($this->stack[$depth - 1]) - 1)){
					return true;
				}
			break;
			case Selector::T_DESCENDANT:
				// Find any matching ascendant if any
				if(!$selector->getParent() || $depth <= 0) return true;
				for($index = $depth - 1; $index >= 0; $index--){
					if($this->isMatchingTail($selector->getParent(), $index, count($this->stack[$index]) - 1)){
						return true;
					}
				}
			break;
			case Selector::T_ADJACENT_SIBLING:
				// Is preceding sibling matching
				if(!$selector->getParent() && $offset <= 0) throw new \Exception('No sibling parent when type expects sibling parent');
				if($this->isMatchingTail($selector->getParent(), $depth, $offset - 1)){
					return true;
				}
			break;
			case Selector::T_GENERAL_SIBLING:
				// Is any preceding sibling matching
				if(!$selector->getParent() && $offset <= 0) throw new \Exception('No sibling parent when type expects sibling parent');
				for($index = $offset - 1; $index >= 0; $index--){
					if($this->isMatchingTail($selector->getParent(), $depth, $index)){
						return true;
					}
				}
			break;
			default: throw new \Exception('Unknown selector type');
		}
		
		return false;
	}

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		/**
		 * @var \csslib\Selector $selector
		 */
		$selector = null;
		
		foreach($this->stack as $siblings){
			foreach($siblings as $index=>$sibling){
				if($index == 0){
					if($selector){
						$selector = $selector->append($sibling, Selector::T_CHILD);
					}else{
						$selector = $selector = clone $sibling;
					}
				}else{
					$selector = $selector->append($sibling, Selector::T_ADJACENT_SIBLING);
				}
			}
		}
		
		
		return Pretty::selector($selector->get());
	}
}