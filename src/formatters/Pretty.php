<?php
namespace csslib\formatters;

/**
 * Formats the css element in a pretty format
 * @author 10usb
 */
class Pretty implements Formatter {
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\formatters\Formatter::format()
	 */
	public function format($segment){
		$css = '';
		foreach($segment->getChildren() as $child){
			$css.= $child."\n\n";
		}
		return $css;
	}
}