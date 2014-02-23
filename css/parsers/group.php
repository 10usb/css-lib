<?php

class CSSGroupParser {
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
		while($this->parser->hasText()){
			// Skip any white-space
			if(preg_match('/^\s+/is', $this->parser->getText(), $matches)){
				$this->parser->move(strlen($matches[0]));
				if(!$this->parser->hasText()) break;
			}
			
			preg_match('/^(@?)(\S+)/is', $this->parser->getText(), $matches);
			
			if($matches[1]){
				switch($matches[2]){
					case 'font-face': $atRule = new CSSFontFaceParser($this->parser, $this->parent); break;
					default: throw new Exception("Unknown At-rule '".$matches[0]."'");
				}
				$atRule->parse();
			}else{
				$ruleset = new CSSRuleSetParser($this->parser, $this->parent);
				$ruleset->parse();
			}
		}
	}
}