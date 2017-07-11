<?php
use csslib\Selector;
use csslib\Attribute;
use csslib\RuleSet;
use csslib\Document;

header('Content-Type: text/plain');

require_once '../autoloader.php';

try {
	$document = new Document();
	$segment = $document->addSegment('user-agent');
	
	$selector = Selector::create()
		->setTagName('body')->addClass('default')->addAttribute('lang', 'nl', Attribute::T_CONTAINS)
		->add(Selector::T_CHILD)->setTagName('section')->addPseudo('first-child')
		->add(Selector::T_ADJACENT_SIBLING)->addPseudo('not', Selector::create()->addClass('apple')->setIdentification('moie')->setTagName('section')->get())->get();
	
	
	$ruleSet = new RuleSet([$selector]);
	$ruleSet->setProperty('font-family', '"Arial Black"');
	$ruleSet->setProperty('color', '#ff8000');	
	$segment->add($ruleSet);
	
	
	print_r($document);
}catch (Exception $ex){
	echo $ex;
}

echo "\n:)";