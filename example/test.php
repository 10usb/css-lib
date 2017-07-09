<?php
use csslib\Selector;
header('Content-Type: text/plain');
include_once '../debug.php';

require_once '../autoloader.php';


$selector = Selector::create()
	->setTagName('body')->addClass('default')
	->add('>')->setTagName('section')->addPseudo('first-child')
	->add()->addPseudo('not', Selector::create()->addClass('apple'))->get();

echo $selector;


echo "\n:)";