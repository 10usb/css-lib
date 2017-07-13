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
$path->push()->addClass('strong');
$path->pop();
$path->push()->addClass('strong');
$path->push()->addClass('span');
$path->pop();
$path->pop();
$path->push()->addClass('strong');
$path->push()->addClass('span');
$path->push()->addClass('a');
$path->pop();
$path->push()->addClass('a');

echo "$path\n";



echo "\n------------------\n";
$formatter = new Pretty();
echo $formatter->format($segment);
echo "\n------------------\n";

echo "\n:)";