<?php
namespace csslib;

/**
 * For storing attribute selector information used when making an selection
 * @author 10usb
 */
class Attribute {
	/**
	 * Matches any element whose value is exactly the same of any elment who has the attrubute when value is empty
	 * @var string T_DEFAULT
	 */
	const T_DEFAULT		= '';
	
	/**
	 * Matches any element whose values whitespace-separated and one of those values is exactly the same
	 * @var string T_IN
	 */
	const T_IN			= '~';
	
	/**
	 * Macthes any element whose value begins with followd by an "-" character
	 * @var string T_FIRST
	 */
	const T_FIRST		= '|';
	
	/**
	 * Macthes any element whose value begins with
	 * @var string T_BEGINS
	 */
	const T_BEGINS		= '^';
	
	/**
	 * Matches any element whose value ends with
	 * @var string T_ENDS
	 */
	const T_ENDS		= '$';
	
	/**
	 * Matches any eleement whose value contains
	 * @var string T_CONTAINS
	 */
	const T_CONTAINS	= '*';
	
	/**
	 *
	 * @var string $key
	 */
	private $key;
	
	/**
	 * The value to be matches
	 * @var string $value
	 */
	private $value;
	
	/**
	 * The matching type
	 * @var string $type
	 */
	private $type;
	
	/**
	 * Constructs an Attribute class with key value and type
	 * @param string $key
	 * @param string $value
	 * @param string $type
	 */
	public function __construct($key, $value, $type){
		$this->key		= $key;
		$this->value	= $value;
		$this->type		= $type;
	}
	
	/**
	 * Returns the CSS representation
	 * @return string
	 */
	public function __toString(){
		if($this->value || $this->type) return '['.$this->key.$this->type.'="'.str_replace('"', '\"', $this->value).'"]';
		return '['.$this->key.']';
	}
}