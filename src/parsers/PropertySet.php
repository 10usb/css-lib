<?php
namespace csslib\parsers;

/**
 * Base class for parsing propery sets
 * @author 10usb
 */
abstract class PropertySet {
	/**
	 * 
	 * @var \csslib\parsers\Parser
	 */
	protected $parser;
	
	/**
	 * 
	 * @var \csslib\PropertySet
	 */
	private $propertySet;
	
	/**
	 * Initializes the internal variables
	 * @param \csslib\parsers\Parser $parser
	 */
	public function __construct($parser){
		$this->parser = $parser;
	}
	
	/**
	 * Sets the target property set
	 * @param \csslib\PropertySet $propertySet
	 */
	public function setPropertySet($propertySet){
		$this->propertySet = $propertySet;
	}
	
	/**
	 * Performs the parsing
	 */
	public function parse(){
		while($this->parser->hasText()){
			if(!preg_match('/\s+(.+?):\s*((\s*(".+?"|[^"]+?)\s*)(\s*,\s*(".+?"|[^"]+?)\s*)*)((;\s*})|(;|\}))/is', $this->parser->getText(), $matches)) throw new \Exception("Invalid property at '".substr($this->parser->getText(), 0, 20)."'");
			$this->parser->move(strlen($matches[0]));
			
			$this->propertySet->setProperty($matches[1], $matches[2]);
			
			if(strpos(end($matches), '}')) break;
		}
	}
}