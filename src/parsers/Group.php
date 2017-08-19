<?php
namespace csslib\parsers;

/**
 * Parses any thing that is allowed in a group
 * @author 10usb
 */
class Group {
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
	 * Performs the parsing
	 */
	public function parse(){
		while($this->parser->hasText()){
			// Skip any white-space
			if(preg_match('/^\s+/is', $this->parser->getText(), $matches)){
				$this->parser->move(strlen($matches[0]));
				if(!$this->parser->hasText()) break;
			}
			
			if(preg_match('/^\/\*/', $this->parser->getText())){
				if(!preg_match('/^\/\*(.+?)\*\//s', $this->parser->getText(), $matches)) throw new \Exception('Unterminated comments');
				$this->parser->move(strlen($matches[0]));
			}else if(preg_match('/^@(\S+)/is', $this->parser->getText(), $matches)){
				switch($matches[2]){
					//case 'font-face': $atRule = new CSSFontFaceParser($this->parser, $this->parent); break;
					default: throw new Exception("Unknown At-rule '".$matches[0]."'");
				}
				$atRule->parse();
			}else{
				$ruleset = new RuleSet($this->parser, $this->parent);
				$ruleset->parse();
			}
		}
	}
}