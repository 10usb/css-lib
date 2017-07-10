<?php
namespace csslib\values;

/**
 * Represents a textual value within quotes
 * @author 10usb
 */
class Text extends Value {
	const PATTERN = '/^"(([^"]\\"|[^"])+)"|\'(([^\']\\\'|[^\'])+)\'$/is';
	
	/**
	 * 
	 * @var string
	 */
	private $text;
	
	/**
	 * (non-PHPdoc)
	 * @see CSSValue::init()
	 */
	protected function init(){
		if(!preg_match(self::PATTERN, $this->value, $matches)) throw new \Exception("Invalid string '$this->value'");
		$this->text = $matches[1];
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CSSValue::getString()
	 */
	public function getText($throw = true){
		return $this->text;
	}
}