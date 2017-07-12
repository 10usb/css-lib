<?php
namespace csslib\parsers;

/**
 * Main class for parsing CSS
 * @author 10usb
 */
class Parser {
	/**
	 * 
	 * @var \csslib\Segment
	 */
	private $segment;
	
	/**
	 * 
	 * @var string
	 */
	private  $text;
	
	/**
	 * 
	 * @var integer
	 */
	private $offset;
	
	/**
	 * 
	 * @param \csslib\Segment $segment
	 */
	public function __construct($segment){
		$this->segment = $segment;
	}
	
	/**
	 * 
	 * @return \csslib\Segment
	 */
	public function getSegment(){
		return $this->segment;
	}
	
	/**
	 * 
	 * @param unknown $text
	 */
	public function setSource($text){
		$this->offset	= 0;
		$this->text		= $text;
		return $this;
	}
	
	/**
	 * Moves the offset with the given count
	 * @param integer $count
	 * @return \csslib\parsers\Parser
	 */
	public function move($count){
		$this->offset+= $count;
		return $this;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getText(){
		return substr($this->text, $this->offset);
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function hasText(){
		return $this->offset < strlen($this->text);
	}
	
	/**
	 * 
	 */
	public function parse(){
		$state = new Group($this, $this->segment);
		$state->parse();
	}
}