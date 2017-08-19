<?php
namespace csslib\query;

/**
 * The specificity defines the priority and thus the order of the properties in an result property set
 * @author 10usb
 */
class Specificity {
	/**
	 * 
	 * @var integer $a
	 * @var integer $b
	 * @var integer $c
	 * @var integer $i
	 */
	private $a = 0, $b = 0, $c = 0, $i = -1;
	
	/**
	 * Set an index for the specificity
	 * @param integer $index
	 */
	public function setIndex($index){
		$this->i = $index;
	}
	
	/**
	 * Returns a string representation of this specificity
	 * @return string
	 */
	public function __toString(){
		return sprintf('%d-%d-%d-%d', $this->a, $this->b, $this->c, $this->i);
	}
	
	/**
	 * Compares to specificities
	 * @param \csslib\query\Specificity $left
	 * @param \csslib\query\Specificity $right
	 * @return integer
	 */
	public static function compare($left, $right){
		if($left->a != $right->a) return $left->a <=> $right->a;
		if($left->b != $right->b) return $left->b <=> $right->b;
		if($left->c != $right->c) return $left->c <=> $right->c;
		if($left->i < 0 || $right->i < 0) return 0;
		return $left->i <=> $right->i;
	}
	
	/**
	 * Calculated the specificity of a selector
	 * @param \csslib\Selector $selector
	 * @return \csslib\query\Specificity
	 */
	public static function get($selector){
		$specificity = $selector->hasNext() ? self::get($selector->getNext()) : new self();
		
		if($selector->getIdentification()) $specificity->a++;
		if($selector->getClasses()) $specificity->b+= count($selector->getClasses());
		if($selector->getAttributes()) $specificity->b+= count($selector->getAttributes());
		if($selector->getPseudos()) $specificity->b+= count($selector->getPseudos());
		if($selector->getTagName()) $specificity->c++;
		
		return $specificity;
	}
}