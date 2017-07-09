<?php
namespace csslib;

class Document {
	/**
	 * Can be a ruleset or an At-Rule
	 * @var \csslib\Segment[]
	 */
	private $segments;
	
	/**
	 *
	 */
	public function __construct(){
		$this->segments	= [];
	}
	
	/**
	 * Return if this document contains a segment with the given name
	 * @param string $name
	 * @return boolean
	 */
	public function contains($name){
		foreach($this->segments as $segment){
			if($segment->getName() == $name) return true;
		}
		return false;
	}
	
	/**
	 * Returns the segment with the given namen otherwise false
	 * @param string $name
	 * @return \csslib\Segment|boolean
	 */
	public function getSegment($name){
		foreach($this->segments as $segment){
			if($segment->getName() == $name) return $segment; 
		}
		return false;
	}
	
	/**
	 * 
	 * @return \csslib\Segment[]
	 */
	public function getSegments(){
		return $this->segments;
	}
}