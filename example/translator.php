<?php
class ExampleTranslator extends CSSTranslator {
	/**
	 * (non-PHPdoc)
	 * @see CSSTranslator::getValue()
	 */
	public function getValue($ruleset, $key){
		$property = $ruleset->getProperty($key);
		if($property){
			switch ($key){
				case 'color': return $property->getColor();
			}

		}
		throw new Exception("Unknow property '$key'");
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see CSSTranslator::inherits()
	 */
	public function inherits($value, $key){
		return false;
	}
}