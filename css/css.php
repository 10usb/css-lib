<?php
class CSSLib {
	public static function init(){
		// Data structure
		include self::path('document.php');
		include self::path('ruleset.php');
		include self::path('selector.php');
		include self::path('property.php');
		include self::path('valuelist.php');
		
		// Values
		include self::path('values/value.php');
		include self::path('values/name.php');
		include self::path('values/string.php');
		include self::path('values/color.php');
		include self::path('values/measurement.php');
		
		// Parser
		include self::path('parser.php');
		
		// Querying
		include self::path('query/match.php');
		include self::path('query/specificity.php');
		include self::path('query/path.php');
		include self::path('query/translator.php');
	}

	public static function path($file){
		return dirname(__FILE__ ).'/'.$file;
	}
}
CSSLib::init();