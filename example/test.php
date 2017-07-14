<?php
use csslib\Document;
use csslib\formatters\Pretty;
use csslib\parsers\Parser;
use csslib\query\Path;

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

$path = new Path($document, null);
$path->push()->setTagName('p')->addClass('special');
$path->push()->setTagName('strong');
$path->pop();
$path->push()->setTagName('strong');

echo "$path\n";
echo "\n------------------\n";

$propertySet = $path->get();
echo $propertySet;



echo "\n------------------\n";
$formatter = new Pretty();
echo $formatter->format($segment);
echo "\n------------------\n";

echo "\n:)";