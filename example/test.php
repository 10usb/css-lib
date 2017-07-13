<?php
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


$formatter = new Pretty();
echo $formatter->format($segment);

echo "\n:)";