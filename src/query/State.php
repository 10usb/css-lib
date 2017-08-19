<?php
namespace csslib\query;

/**
 * Used to store a state in the chain of property sets constructed by a path
 * @author 10usb
 */
class State {
	/**
	 * 
	 * @var \csslib\Document
	 */
	private $document;
	
	/**
	 * 
	 * @var \csslib\query\Translator
	 */
	private $translator;
	
	/**
	 * 
	 * @var \csslib\query\Chain
	 */
	private $chain;
	
	/**
	 * Constructs a state object
	 * @param \csslib\Document $document
	 * @param \csslib\query\Translator $translator
	 * @param \csslib\query\Chain $chain
	 */
	public function __construct($document, $translator, $chain){
		$this->document		= $document;
		$this->translator	= $translator;
		$this->chain		= $chain;
	}
	
	/**
	 * Returns the calculated property value
	 * @param string $key
	 * @return mixed
	 */
	public function getValue($key){
		return $this->translator->getValue($this->chain, $this->document, $key);
	}
}