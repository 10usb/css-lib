<?php
namespace csslib\parsers;

class Parser {
	/**
	 * 
	 * @var CSSDocument
	 */
	private $document;
	
	/**
	 * 
	 * @param CSSDocument $document
	 */
	public function __construct($document){
		$this->document = $document;
	}
	
	/**
	 * 
	 * @return CSSDocument
	 */
	public function getDocument(){
		return $this->document;
	}
	
	/**
	 * 
	 */
	public function move($count){
		$this->offset+= $count;
	}
	
	/**
	 * 
	 */
	public function getText(){
		return substr($this->text, $this->offset);
	}
	
	/**
	 * 
	 */
	public function hasText(){
		return $this->offset < strlen($this->text);
	}
	
	/**
	 * 
	 * @param string $test
	 */
	public function parse($text){
		$this->offset = 0;
		$this->text = $text;
		
		$state = new CSSGroupParser($this, $this->document);
		$state->parse();
	}
}