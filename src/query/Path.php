<?php
namespace csslib\query;

use csslib\Selector;
use csslib\PropertySet;

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
	 * @param \csslib\Document $document
	 * @param \csslib\query\Translator $translator
	 */
	public function __construct($document, $translator){
		$this->document		= $document;
		$this->translator	= $translator;
		$this->depth		= 0;
		$this->stack		= [];
	}
	
	/**
	 * 
	 * @return \csslib\Selector
	 */
	public function push(){
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
		$this->depth--;
	}
	
	/**
	 * 
	 * @return \csslib\PropertySet
	 */
	public function get(){
		$matches = [];
		$walker = new Walker($this->document, $this->translator);
		foreach($walker as $index=>$ruleSet){
			$this->match($matches, $ruleSet, $index);
		}
		
		usort($matches, function($a, $b){
			return Specificity::compare($a[0], $b[0]);
		});
		
		$propertySet = new PropertySet();
		foreach ($matches as $match){
			foreach($match[1]->getProperties() as $property){
				$propertySet->setProperty($property);
			}
		}
		return $propertySet;
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
		return rand(0, 2)==0;
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
		
		
		return $selector->get()->__toString();
	}
}