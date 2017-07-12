<?php
namespace csslib\parsers;

use csslib\Selector;

/**
 * Parses a ruleset
 * @author 10usb
 */
class RuleSet {
	/**
	 * @var \csslib\parsers\Parser
	 */
	private $parser;
	
	/**
	 * @var \csslib\Group
	 */
	private $parent;
	
	/**
	 *
	 * @param \csslib\parsers\Parser $parser
	 * @param \csslib\Group $parent
	 */
	public function __construct($parser, $parent){
		$this->parser = $parser;
		$this->parent = $parent;
	}
	
	/**
	 * 
	 */
	public function parse(){
		if(!preg_match('/(.+?)\s*{/is', $this->parser->getText(), $matches)) throw new \Exception("Invalid selector at '".substr($this->getText(), 0, 20)."'");
		$this->parser->move(strlen($matches[0]));
		
		$selectors = array();
		foreach(explode(',', $matches[1]) as $selector){
			$selectors[] = $this->parseSelector(trim($selector));
		}
		
		$ruleSet = new \csslib\RuleSet($selectors);
		$ruleSet->setProperty('font-family', '"Arial Black"');
		$ruleSet->setProperty('color', '#ff8000');
		$this->parent->add($ruleSet);
		
		//$ruleset = $this->parent->createRuleSet($selectors);

		//$state = new CSSPropertySetParser($this->parser, $ruleset);
		//$state->parse();
	}
	
	public function parseSelector($text){
		$text = preg_replace('/(\>)\s+/is', '>', $text);
		
		$selector	= null;
		
		foreach(preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY) as $part){
			if(!preg_match('/^([\>\+~]?)([^ >]+)$/is', $part, $matches)) throw new \Exception("Invalid selector part '$part'");
			
			$selector = $selector ? $selector->add($matches[1] ? $matches[1] : false) : Selector::create();
			
			$offset = 0;
			
			$subtext = $matches[2];
			while($offset < strlen($subtext)){
				if(!preg_match('/^([\.:#]?)([a-z0-1\-]+)/is', substr($subtext, $offset), $matches)) throw new \Exception("Invalid property at '".substr($text, $offset, 20)."'");
				
				switch($matches[1]){
					case '': $selector->setTagName($matches[2]); break;
					case '#': $selector->setIdentification($matches[2]); break;
					case '.': $selector->addClass($matches[2]); break;
					case ':': $selector->addPseudo($matches[2]); break;
					default: throw new \Exception("Knonwn type '".$matches[1]."'");
				}

				$offset+= strlen($matches[0]);
			}
		}

		return $selector->get();
	}
}