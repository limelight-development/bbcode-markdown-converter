<?php

use Limelight\Converter\Converter;

require __DIR__ . '/vendor/autoload.php';

file_put_contents(
	__DIR__ . '/data/test_post.md',
	(new Converter(file_get_contents(__DIR__ . '/data/test_post.bb')))
		->bbToMarkdown()
		->getText()
);