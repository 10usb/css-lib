<?php
namespace csslib;

/**
 * Base class for any set that can contain rulesets, for example the document or an media query
 * @author 10usb
 */
abstract class Group {
	/**
	 * Can be a ruleset or an At-Rule
	 * @var \csslib\RuleSet[]
	 */
	private $children;
	
	/**
	 * Initialize the internal values
	 */
	public function __construct(){
		$this->children	= [];
	}
	
	/**
	 * Returns all the direct childeren of this group 
	 * @return \csslib\RuleSet[]
	 */
	public function getChildren(){
		return $this->children;
	}
	
	/**
	 * Adds an child to this group
	 * @param \csslib\RuleSet $child Child to be added
	 * @param \csslib\RuleSet $other If given the child to be added wil be inserted before the other child
	 * @return \csslib\RuleSet The added child
	 */
	public function add($child, $other = null){
		if($other){
			throw new \Exception('Inserting before not supported');
		}else{
			$this->children[] = $child;
		}
		return $child;
	}
}
