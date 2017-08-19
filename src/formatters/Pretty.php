<?php
namespace csslib\formatters;

/**
 * Formats the CSS elements in a pretty format
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
	
	/**
	 * Formats a selector
	 * @param \csslib\Selector $selector
	 * @param boolean $child
	 * @return string
	 */
	public static function selector($selector, $child = true){
		$css = '';
		if($selector->getType()){
			$css.= $selector->getType().' ';
		}
		if(!$selector->getTagName()&& !$selector->getIdentification() && !$selector->getClasses() && !$selector->getPseudos()){
			$css.= '*';
		}else{
			if($selector->getTagName()){
				$css.= $selector->getTagName();
			}
			if($selector->getAttributes()){
				$css.= implode('', $selector->getAttributes());
			}
			if($selector->getIdentification()){
				$css.= '#'.$selector->getIdentification();
			}
			if($selector->getClasses()){
				$css.= '.'.implode('.', $selector->getClasses());
			}
			if($selector->getPseudos()){
				$css.= ':'.implode(':', $selector->getPseudos());
			}
			if($child && $selector->getNext()){
				$css.= ' '.self::selector($selector->getNext(), true);
			}
		}
		return $css;
	}
}