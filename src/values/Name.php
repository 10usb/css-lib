<?php
namespace csslib\values;

/**
 * Represents a textual value without whitespaces
 * @author 10usb
 */
class Name extends Value {
	/**
	 * Regex pattern to validate a name value
	 * @var string PATTERN
	 */
	const PATTERN = '/^([a-z\-]([a-z0-9-_]*[a-z0-9])?)$/is';
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::getName()
	 */
	public function getName($throw = true){
		return $this->value;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::getText()
	 */
	public function getText($throw = true){
		return $this->value;
	}
}