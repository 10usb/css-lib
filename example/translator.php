<?php
class ExampleTranslator extends CSSTranslator {
	/**
	 * (non-PHPdoc)
	 * @see CSSTranslator::getValue()
	 */
	public  function translate($key, $value, $ruleset){
		switch($key){
			case 'page-margin':
				if($value->getCount()==4){
					$ruleset->setProperty('page-margin-top', $value->getValue(0));
					$ruleset->setProperty('page-margin-right', $value->getValue(1));
					$ruleset->setProperty('page-margin-bottom', $value->getValue(2));
					$ruleset->setProperty('page-margin-left', $value->getValue(3));
				}
			break;
			default: $ruleset->setProperty($key, $value); break;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CSSTranslator::getValue()
	 */
	public function getValue($ruleset, $key){
		$property = $ruleset->getProperty($key);
		if($property){
			switch($key){
				case 'color': return $property->getColor();
				case 'page-margin-top': return $property->getMeasurement('pt');
				case 'page-margin-right': return $property->getMeasurement('pt');
				case 'page-margin-bottom': return $property->getMeasurement('pt');
				case 'page-margin-left': return $property->getMeasurement('pt');
			}
			throw new Exception("Unknow property '$key'");
		}
		return null;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see CSSTranslator::inherits()
	 */
	public function inherits($value, $key){
		return false;
	}
}