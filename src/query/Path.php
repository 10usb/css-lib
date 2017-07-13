<?php
namespace csslib\query;

use csslib\Selector;

class Path {
	/**
	 * 
	 * @var \csslib\Document
	 */
	private $documment;
	
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