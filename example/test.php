<?php
use csslib\Selector;
use csslib\values\Value;
use csslib\Attribute;

header('Content-Type: text/plain');
include_once '../debug.php';

require_once '../autoloader.php';

try {
	$selector = Selector::create()
		->setTagName('body')->addClass('default')->addAttribute('lang', 'nl', Attribute::T_CONTAINS)
		->add(Selector::T_CHILD)->setTagName('section')->addPseudo('first-child')
		->add(Selector::T_ADJACENT_SIBLING)->addPseudo('not', Selector::create()->addClass('apple')->setIdentification('moie')->setTagName('section')->get())->get();
	
	echo $selector;
	
	
	
	$value = Value::parse('hallo');
	print_r($value);
	echo $value;
	
	$value = Value::parse('"hallo daar"');
	print_r($value);
	echo $value;
	
	$value = Value::parse('15px');
	print_r($value);
	echo $value;
	
	$value = Value::parse('#ff8000');
	print_r($value);
	echo $value;
	
	$value = Value::parse('#f80');
	print_r($value);
	echo $value;
	
}catch (Exception $ex){
	echo $ex;
}

echo "\n:)";