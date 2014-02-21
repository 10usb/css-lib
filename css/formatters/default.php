<?php

class CSSDefaultFormatter implements CSSFormatter {
	private static $instance = null;
	
	public static function getInstance(){
		if(!self::$instance) self::$instance = new CSSDefaultFormatter();
		return self::$instance;
	}
	
	public function document(CSSDocument $document){
		$css = '';
		foreach($document->getRuleSets() as $ruleset){
			$css.= $ruleset."\n";
		}
		return $css;
		
	}
}