<?php

class CSSFontFaceParser {
	/**
	 * @var CSSParser
	 */
	private $parser;
	
	/**
	 * @var CSSGroup
	 */
	private $parent;
	
	public function __construct($parser, $parent){
		$this->parser = $parser;
		$this->parent = $parent;
	}
	
	public function parse(){
		if(!preg_match('/(.+?)\s*{/is', $this->parser->getText(), $matches)) throw new Exception("Invalid selector at '".substr($this->getText(), 0, 20)."'");
		
		$this->parser->move(strlen($matches[0]));
		
		$ruleset = $this->parent->createRuleSet(array());

		$state = new CSSPropertySetParser($this->parser, $ruleset);
		$state->parse();
	}
}