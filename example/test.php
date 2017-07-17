<?php
use csslib\Document;
use csslib\formatters\Pretty;
use csslib\parsers\Parser;
use csslib\query\Path;

header('Content-Type: text/plain');

require_once '../autoloader.php';
require_once 'translator.php';


$document = new Document();
$segment = $document->addSegment('user-agent');

try {
	$parser = new Parser($segment);
	$parser->setSource(file_get_contents('doc.css'));
	$parser->parse();
}catch (Exception $ex){
	echo $ex;
}

$path = new Path($document, new ExampleTranslator());
$path->push()->setTagName('section');

echo "---- Some translated properties ----\n";
echo "PATH: $path\n";
echo 'page-margin-top: '.$path->getValue('page-margin-top')."\n";
echo 'page-margin-right: '.$path->getValue('page-margin-right')."\n";
echo 'page-margin-bottom: '.$path->getValue('page-margin-bottom')."\n";
echo 'page-margin-left: '.$path->getValue('page-margin-left')."\n";
echo "\n";

$path->push()->setTagName('p')->addClass('special');
$path->push()->setTagName('strong');
$path->pop();
$path->push()->setTagName('span');
$path->push()->setTagName('strong');

echo "---- Some inherited properties -----\n";
echo "PATH: $path\n";
echo 'color: '.$path->getValue('color');
echo "\n";

echo "\n------- Pretty print output --------\n";
$formatter = new Pretty();
echo $formatter->format($segment);
echo "\n";

echo ":)";