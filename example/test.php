<?php
use csslib\Selector;
use csslib\Attribute;
use csslib\RuleSet;
use csslib\Document;
use csslib\formatters\Pretty;
use csslib\parsers\Parser;

header('Content-Type: text/plain');

require_once '../autoloader.php';


$document = new Document();
$segment = $document->addSegment('user-agent');

try {
	$parser = new Parser($segment);
	$parser->setSource(file_get_contents('doc.css'));
	$parser->parse();

}catch (Exception $ex){
	echo $ex;
}

$selector = Selector::create()
	->setTagName('body')->addClass('default')->addAttribute('lang', 'nl', Attribute::T_CONTAINS)
	->add(Selector::T_CHILD)->setTagName('section')->addPseudo('first-child')
	->add(Selector::T_ADJACENT_SIBLING)->addPseudo('not', Selector::create()->addClass('apple')->setIdentification('moie')->setTagName('section')->get())->get();


$ruleSet = new RuleSet([$selector]);
$ruleSet->setProperty('font-family', '"Arial Black"');
$ruleSet->setProperty('color', '#ff8000');	
$segment->add($ruleSet);


$formatter = new Pretty();
	echo $formatter->format($segment);


echo "\n:)";