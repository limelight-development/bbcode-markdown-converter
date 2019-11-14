<?php

require __DIR__ . '/vendor/autoload.php';
$conv = new \Limelight\Converter\Converter();
$conv->setText(file_get_contents(__DIR__ . '/data/test_post.bb'));
$conv->bbToMarkdown();
file_put_contents(__DIR__ . '/data/test_post.md', $conv->getText());