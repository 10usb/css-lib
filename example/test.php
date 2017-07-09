<?php
use csslib\Selector;

include_once '../debug.php';

require_once '../autoloader.php';


$selector = new Selector(false, 'body', ['default'], false);

echo $selector;

echo "\n:)";