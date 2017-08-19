<?php
namespace csslib;

/**
 * The main class for processing a cascading style sheet files. It may contain multiple segments the each can represent a file
 * @author 10usb
 */
class Document {
	/**
	 * All the segment in the document on which query can be made
	 * @var \csslib\Segment[]
	 */
	private $segments;
	
	/**
	 * Construct a new document
	 */
	public function __construct(){
		$this->segments	= [];
	}
	
	/**
	 * Return true if this document contains a segment with the given name
	 * @param string $name Name of the segment
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
	 * @param string|\csslib\Segment $segment Segment to be addded
	 * @param \csslib\Segment $other If given the segment to be added wil be inserted before the other segment
	 * @return \csslib\Segment The added segment
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
	 * Returns the segment with the given name otherwise false
	 * @param string $name Name of the segment
	 * @return \csslib\Segment|boolean
	 */
	public function getSegment($name){
		foreach($this->segments as $segment){
			if($segment->getName() == $name) return $segment; 
		}
		return false;
	}
	
	/**
	 * Returns an array of all the segment in this document
	 * @return \csslib\Segment[]
	 */
	public function getSegments(){
		return $this->segments;
	}
	
	/**
	 * Returns the index of the segment 
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