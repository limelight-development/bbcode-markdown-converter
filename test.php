<?php

use Limelight\Converter\Converter;

require __DIR__ . '/vendor/autoload.php';

$bbcode = file_get_contents(__DIR__ . '/data/bbcode-source');

$converter = new Converter();
$converter->setText($bbcode);

$converter->bbToMarkdown();
//file_put_contents(__DIR__ . '/data/bbcode-converted', $converter->getText());
//
//$converter->markdownToBB();
//file_put_contents(__DIR__ . '/data/bbcode-reversed', $converter->getText());
//
//$converter->setText($bbcode);
//$converter->bbToMarkdown()->bbToMarkdown();
//file_put_contents(__DIR__ . '/data/bbcode-double', $converter->getText());
//
//
//$markdown = file_get_contents(__DIR__ . '/data/markdown-source');
//
//$converter = new Converter();
//$converter->setText($markdown);
//
//$converter->markdownToBB();
//file_put_contents(__DIR__ . '/data/markdown-converted', $converter->getText());
//
//$converter->bbToMarkdown();
//file_put_contents(__DIR__ . '/data/markdown-reversed', $converter->getText());
//
//$converter->setText($markdown);
//$converter->markdownToBB()->markdownToBB();
//file_put_contents(__DIR__ . '/data/markdown-double', $converter->getText());