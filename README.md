# css-lib

This library allowes you parse a Cascading Style Sheets (CSS) document from which you can query property values given a path. The translation with of without inheritance of the values is up to you to decide. This gives you the freedom to create your own rules.

The path to construct is stack based, therefore it is easily implemented in recursive procedures. For example traversing a DOM structure.

## Example
```php
$document = new Document();

$parser = new Parser($document->addSegment('style.css')); // could be any name
$parser->setSource(file_get_contents('style.css'));
$parser->parse();


$path = new Path($document, new ExampleTranslator());
$path->push()->setTagName('html');
$path->push()->setTagName('body');
$path->push()->setTagName('section')->addClass('slides');

// prints the height value the section slide would get
echo $path->getValue('height');
```

As an extra this library supports is the ability to minify or reformat the contents by loading it and then respoduce with a new format.

## TODO's
 - Support for At-Rules
 - Default example kit for a HTML inliner
 - Make a HTMLify formatter set
