<?php
header('Content-Type: text/plain');

include '../css/css.php';
include 'translator.php';

$document = new CSSDocument();
$parser = new CSSParser($document);
$parser->parse(file_get_contents('doc.css'));

$path = new CSSPath($document, new ExampleTranslator());
$path->push('section', null, null);
$path->push('body', null, null);
$path->push('p', array('special'), null);
$path->push('span', null, null);
$path->push('strong', null, null);

echo $path."\n\n";
print_r($path->getValue('color'));
echo "\n";

echo $document;