<?php
header('Content-Type: text/plain');

include '../css/css.php';
include 'formatter.php';

$document = new CSSDocument();
$parser = new CSSParser($document);
$parser->parse(file_get_contents('doc.css'));

echo $document;

echo $document->format(new MinifyFormatter());