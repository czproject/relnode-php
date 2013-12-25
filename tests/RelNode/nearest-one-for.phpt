<?php
use Tester\Assert;
require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../../src/RelNode.php';

$root = new Cz\RelNode;

// Empty object
test(function() use ($root) {
	Assert::null($root->getNearestOneFor('path/to/here'));
});

$root->addChild('/', '@layout');
$root->addChild('/cs', 'cs/@layout');
$root->addChild('/en/documentation', 'en/documentation/@layout');
$root->addChild('/en/forum/docs', 'en/forum/docs/@layout');

// Unexists path
test(function() use ($root) {
	Assert::same('@layout', value($root->getNearestOneFor('path/not/found')));
});

// Normal
test(function() use ($root) {
	Assert::same('@layout', $root->value);
	Assert::same('cs/@layout', value($root->getNearestOneFor('cs')));
	Assert::same('@layout', value($root->getNearestOneFor('en')));
	Assert::same('@layout', value($root->getNearestOneFor('en/forum')));
	Assert::same('en/forum/docs/@layout', value($root->getNearestOneFor('en/forum/docs')));
	Assert::same('en/forum/docs/@layout', value($root->getNearestOneFor('en/forum/docs/index')));
	Assert::same('en/forum/docs/@layout', value($root->getNearestOneFor('en/forum/docs/help/index')));
	Assert::same('en/documentation/@layout', value($root->getNearestOneFor('en/documentation')));
	Assert::same('en/documentation/@layout', value($root->getNearestOneFor('en/documentation/v1.0.0/templating')));
});

