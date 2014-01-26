<?php
header('Content-Type: text/plain');

include '../css/css.php';

$document = new CSSDocument();
$parser = new CSSParser($document);
$parser->parse(file_get_contents('doc.css'));

foreach($document->getRuleSets() as $ruleset){
	$selectors = array();
	foreach($ruleset->getSelectors() as $selector){
		$selector = str_replace(' > ', '>', $selector);
		$selector = str_replace(' + ', '+', $selector);
		$selector = str_replace(' ~ ', '~', $selector);
		$selectors[] = $selector;
	}
	echo implode(', ', $selectors)."{";
	foreach($ruleset->getProperties() as $key=>$value){
		echo "$key: $value;";
	}
	echo "}\n";
}