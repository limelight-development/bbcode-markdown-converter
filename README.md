# bbcode-markdown-converter
A simple converter for switching between BBCode and Markdown.

## Purpose

Whilst there are lots of converters for changing BBCode into Markdown, there aren't many that work in reverse.
The aim of this package is to fix that, giving an easily expandable, simple to use class for converting between the two formats.

## Installation

```bash
composer require limelight/bbcode-markdown-converter
```

Simple as that.

## Example Use

Using the library is pretty easy. First up, converting from BBCode to Markdown.
```php
use \Limelight\Converter\Converter;

require __DIR__ . '/vendor/autoload.php';

$bbCode = file_get_contents(__DIR__ . '/data/test_post.bb'); // Pull the test post.

$conv = new Converter($bbCode)
$conv->bbToMarkdown();
echo $conv->getText();
```

Easy, right? And the other way around.
```php
use \Limelight\Converter\Converter;

require __DIR__ . '/vendor/autoload.php';

$mdText = file_get_contents(__DIR__ . '/data/test_md.md'); // Pull the test post.

$conv = new Converter($mdText)
$conv->markdownToBB();
echo $conv->getText();
```