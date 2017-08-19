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
	 * Constructs a parser for a target segment
	 * @param \csslib\Segment $segment
	 */
	public function __construct($segment){
		$this->segment = $segment;
	}
	
	/**
	 * Returns the target segment
	 * @return \csslib\Segment
	 */
	public function getSegment(){
		return $this->segment;
	}
	
	/**
	 * Sets the source for parse
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
	 * Returns the text that remains
	 * @return string
	 */
	public function getText(){
		return substr($this->text, $this->offset);
	}
	
	/**
	 * Returns true if there is remaining text
	 * @return boolean
	 */
	public function hasText(){
		return $this->offset < strlen($this->text);
	}
	
	/**
	 * Performs the parsing
	 */
	public function parse(){
		$state = new Group($this, $this->segment);
		$state->parse();
	}
}