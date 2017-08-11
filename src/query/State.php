<?php
namespace csslib\query;

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
	 * 
	 * @param unknown $document
	 * @param unknown $translator
	 * @param unknown $chain
	 */
	public function __construct($document, $translator, $chain){
		$this->document		= $document;
		$this->translator	= $translator;
		$this->chain		= $chain;
	}
	
	/**
	 * 
	 * @param string $key
	 * @return mixed
	 */
	public function getValue($key){
		return $this->translator->getValue($this->chain, $this->document, $key);
	}
}