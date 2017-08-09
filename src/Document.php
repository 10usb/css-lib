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
	 * Adds a new segment 
	 * @param string|\csslib\Segment $segment
	 * @param \csslib\Segment $other
	 * @return \csslib\Segment
	 */
	public function addSegment($segment, $other = null){
		if(!$segment instanceof Segment){
			$segment = new Segment($segment);
		}
		if($this->getIndexOf($segment->getName())) throw new \Exception('Section with this name already exists');
		if($other){
			if(($index = $this->getIndexOf($other))===false) throw new \Exception('Segment not found');
			array_splice($this->segments, $index, 0, [$segment]);
		}else{
			$this->segments[] = $segment;
		}
		return $segment;
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
	
	/**
	 * 
	 * @param string|\csslib\Segment $segment
	 * @return \csslib\Segment|boolean
	 */
	private function getIndexOf($segment){
		if($segment instanceof Segment){
			foreach($this->segments as $index=>$other){
				if($other === $segment){
					return $index;
				}
			}
		}else{
			foreach($this->segments as $index=>$other){
				if($other->getName() === $segment){
					return $index;
				}
			}
		}
		return false;
	}
}