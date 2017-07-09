<?php
namespace csslib;

abstract class Group {
	/**
	 * Can be a ruleset or an At-Rule
	 * @var mixed
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
	
}
