<?php
namespace csslib\query;

/**
 * The translator is resposible for returning the calculated value
 * Example: when the set only contains an margin property and property margin-left is retrieved the translator known how to get the correct value
 * 
 * @author 10usb
 */
interface Translator {
	/**
	 * Method to retrieve a calculated value
	 * @param \csslib\query\Chain $chain
	 * @param \csslib\Document $document
	 * @param string $key
	 * @return mixed|\csslib\values\Value|\csslib\ValueList
	 */
	public function getValue($chain, $document, $key);
}