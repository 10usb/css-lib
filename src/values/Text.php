<?php
namespace csslib\values;

/**
 * Represents a textual value within quotes
 * @author 10usb
 */
class Text extends Value {
	/**
	 * Regex pattern to validate a text value
	 * @var string PATTERN
	 */
	const PATTERN = '/^"(([^"]\\"|[^"])+)"|\'(([^\']\\\'|[^\'])+)\'$/is';
	
	/**
	 * The parsed textual value
	 * @var string
	 */
	private $text;
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::init()
	 */
	protected function init(){
		if(!preg_match(self::PATTERN, $this->value, $matches)) throw new \Exception("Invalid string '$this->value'");
		$this->text = stripslashes($matches[1]);
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::getText()
	 */
	public function getText($throw = true){
		return $this->text;
	}
}