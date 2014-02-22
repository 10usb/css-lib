<?php

class CSSGroupParser {
	/**
	 * @var CSSParser
	 */
	private $parser;
	
	public function __construct($parser){
		$this->parser = $parser;
	}
	
	public function parse(){
		while($this->parser->hasText()){
			if(preg_match('/^\s+/is', $this->parser->getText(), $matches)){
				$this->parser->move(strlen($matches[0]));
				if(!$this->parser->hasText()) break;
			}
			if(!preg_match('/\s*(.+?)\s*{/is', $this->parser->getText(), $matches)) throw new Exception("Invalid selector at '".substr($this->getText(), 0, 20)."'");
			$this->parser->move(strlen($matches[0]));
			
			$selectors = array();
			foreach(explode(',', $matches[1]) as $selector){
				$selectors[] = $this->parseSelector(trim($selector));
			}
			$ruleset = $this->parser->getDocument()->createRuleSet($selectors);
	
			$state = new CSSPropertySetParser($this->parser, $ruleset);
			$state->parse();
		}
	}
	
	public function parseSelector($text){
		$text = preg_replace('/(\>)\s+/is', '>', $text);
		
		$selector	= null;
		$current	= null;
		
		foreach(preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY) as $part){
			if(!preg_match('/^(\>?)([^ >]+)$/is', $part, $matches)) throw new Exception("Invalid selector part '$part'");
			
			$type		= $matches[1] ? $matches[1] : null;
			$tagName	= null;
			$classes	= array();
			$pseudos	= array();
			
			$offset = 0;
			
			$subtext = $matches[2];
			
			while($offset < strlen($subtext)){
				if(!preg_match('/^([\.:]?)([a-z0-1\-]+)/is', substr($subtext, $offset), $matches)) throw new Exception("Invalid property at '".substr($text, $offset, 20)."'");
				
				switch($matches[1]){
					case '.': $classes[] = $matches[2]; break;
					case ':': $pseudos[] = $matches[2]; break;
					default: $tagName =  $matches[2]; break;
				}

				$offset+= strlen($matches[0]);
			}
			
			if($current==null){
				$selector = $current = new CSSSelector($type, $tagName, $classes, $pseudos);
			}else{
				$current = $current->setSelector(new CSSSelector($type, $tagName, $classes, $pseudos));
			}
		}

		return $selector;
	}
}