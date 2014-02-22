css-lib
=======

This library allowes you start a CSS document from wich you can fetch property values given a path.
The translation with of without inheritance of the values is up to you to decide.
This gives you the freedom to create your own rules.

The path you can construct is stack bases and therefore easily implemented in recursive functions.
For example traversing a DOM structure.

As an extra this library support the ability to minify or reformat the CSS by loading the css en respoduce with a new format.

TODO:
 - Support for At-Rules by adding a extra layer between the document and the rulesets
 - Default kit for processing html
 - Use that kit to make een example inliner
 - Make "better" use of a formatter class in to toString functions, allowing easy minifying or formatting of code, setting the formatting as default.
 - Make a HTMLify formatter set
