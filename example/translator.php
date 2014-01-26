<?php
class ExampleTranslator extends CSSTranslator {
	/**
	 * (non-PHPdoc)
	 * @see CSSTranslator::getValue()
	 */
	public  function translate($key, $value, $ruleset){
		switch($key){
			case 'page-margin':
				if($value->getValueList(0)->getCount()==4){
					$ruleset->setProperty('page-margin-top', $value->getValueList(0)->getValue(0));
					$ruleset->setProperty('page-margin-right', $value->getValueList(0)->getValue(1));
					$ruleset->setProperty('page-margin-bottom', $value->getValueList(0)->getValue(2));
					$ruleset->setProperty('page-margin-left', $value->getValueList(0)->getValue(3));
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
				case 'color': return $property->getValueList(0)->getValue(0);
				case 'page-margin-top': return $property->getValueList(0)->getValue(0)->getMeasurement('pt');
				case 'page-margin-right': return $property->getValueList(0)->getValue(0)->getMeasurement('pt');
				case 'page-margin-bottom': return $property->getValueList(0)->getValue(0)->getMeasurement('pt');
				case 'page-margin-left': return $property->getValueList(0)->getValue(0)->getMeasurement('pt');
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