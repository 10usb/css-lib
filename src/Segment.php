<?php
namespace csslib;

/**
 * A document can consist of 1 or multiple segments
 * @author tinus
 */
class Segment extends Group {
	/**
	 * Name of the segment
	 * @var string
	 */
	private $name;
	
	/**
	 * Name of the segment. example "user-agent stylesheet" or the file name
	 * @param string $name
	 */
	public function __construct($name){
		parent::__construct();
		$this->name = $name;
	}
	
	/**
	 * Name of the segment
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Returns the CSS
	 * @param csslib\formatters\Formatter $formatter
	 * @return string
	 */
	public function format($formatter){
		return $formatter->segment($this);
	}
}