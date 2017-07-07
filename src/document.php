<?php

class CSSDocument extends CSSGroup {
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * Returns the CSS
	 * @return string
	 */
	public function format($formatter){
		return $formatter->document($this);
	}

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		return $this->format(CSSDefaultFormatter::getInstance());
	}
}