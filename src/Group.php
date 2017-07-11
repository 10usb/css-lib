<?php
namespace csslib;

abstract class Group {
	/**
	 * Can be a ruleset or an At-Rule
	 * @var mixed[]
	 */
	private $children;
	
	/**
	 * 
	 */
	public function __construct(){
		$this->children	= [];
	}
	
	/**
	 * 
	 * @return mixed[]
	 */
	public function getChildren(){
		return $this->children;
	}
	
	/**
	 * 
	 * @param mixed $child
	 * @param mixed $other
	 * @return mixed
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
