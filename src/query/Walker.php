<?php
namespace csslib\query;

use csslib\RuleSet;
use csslib\Group;

/**
 * Iterates over a document returning every ruleset in it
 * @author 10usb
 */
class Walker implements \Iterator {
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
	 * @var ArrayIterator[]
	 */
	private $stack;
	
	/**
	 * 
	 * @var integer
	 */
	private $index;
	
	/**
	 * 
	 * @var \csslib\RuleSet
	 */
	private $current;
	
	/**
	 *
	 * @param \csslib\Document $document
	 * @param \csslib\query\Translator $translator
	 */
	public function __construct($document, $translator){
		$this->document		= $document;
		$this->translator	= $translator;
		
		$this->stack		= [];
		$this->index		= -1;
		$this->current		= null;
	}
	
	/**
	 * 
	 */
	public function rewind(){
		$this->stack = [ new \ArrayIterator($this->document->getSegments()) ];
		
		$this->index		= -1;
		$this->current		= null;
		$this->fetch();
	}
	
	private function fetch(){
		$iterator = end($this->stack);
		
		if(!$iterator->valid()){
			do {
				array_pop($this->stack);
				if(!$this->stack) return;
				
				$iterator = end($this->stack);
			}while(!$iterator->valid());
		}
		
		$value = $iterator->current();
		if($value instanceof RuleSet){
			$this->current = $value;
			$this->index++;
		}elseif($value instanceof Group){
			$iterator->next();
			$this->stack[] = new \ArrayIterator($value->getChildren());
			$this->fetch();
		}else{
			$this->next();
		}
	}
	
	/**
	 *
	 */
	public function next(){
		$iterator = end($this->stack);
		$iterator->next();
		$this->fetch();
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function valid(){
		return !!$this->stack;
	}
	
	/**
	 * 
	 * @return \csslib\RuleSet
	 */
	public function current(){
		return $this->current;
	}
	
	/**
	 * 
	 * @return integer
	 */
	public function key(){
		return $this->index;
	}
}