<?php
namespace csslib\query;

/**
 * 
 * @author 10usb
 */
interface Translator {
	/**
	 * 
	 * @param \csslib\query\Chain $chain
	 * @param \csslib\Document $document
	 * @param string $key
	 * @return mixed|\csslib\values\Value|\csslib\ValueList
	 */
	public function getValue($chain, $document, $key);
}