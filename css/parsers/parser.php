<?php

class CSSParser {
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
		
		$state = new CSSGroupParser($this);
		$state->parse();
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