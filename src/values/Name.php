<?php
namespace csslib\values;

/**
 * Represents a textual value without whitespaces
 * @author 10usb
 */
class Name extends Value {
	const PATTERN = '/^([a-z\-]([a-z0-9-_]*[a-z0-9])?)$/is';
	
	/**
	 * (non-PHPdoc)
	 * @see CSSValue::getName()
	 */
	public function getName($throw = true){
		return $this->value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CSSValue::getString()
	 */
	public function getText($throw = true){
		return $this->value;
	}
}