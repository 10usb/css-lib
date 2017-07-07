<?php

class CSSPropertySetParser {
	/**
	 * @var CSSParser
	 */
	private $parser;
	
	public function __construct($parser, $propertyset){
		$this->parser = $parser;
		$this->propertyset = $propertyset;
	}
	
	public function parse(){
		while($this->parser->hasText()){
			if(!preg_match('/\s+(.+?):\s*((\s*(".+?"|[^"]+?)\s*)(\s*,\s*(".+?"|[^"]+?)\s*)*)((;\s*})|(;|\}))/is', $this->parser->getText(), $matches)) throw new Exception("Invalid property at '".substr($this->parser->getText(), 0, 20)."'");
			$this->parser->move(strlen($matches[0]));
			
			$this->propertyset->setProperty($matches[1], $matches[2]);
			
			if(strpos(end($matches), '}')) break;
		}
	}
}