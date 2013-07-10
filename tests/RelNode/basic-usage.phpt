<?php
use Tester\Assert;
require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../../src/RelNode.php';

$root = new Cz\RelNode;
$root->value = 'Root value';

// Add children
test(function() use ($root) {
	Assert::true($root->addChild('subdir', 'SubDir Value'));
	Assert::true($root->addChild('subdir/subsub', 'Sub Sub Value'));
	Assert::true($root->addChild('sub/subdir/subdir', 'Sub Value'));
});



// Get first filled (root value)
test(function() use ($root) {
	$node = $root->getFirstFilled();
	Assert::same('Root value', $node->value);
});



// Get nearest filled children
test(function() use ($root) {
	Assert::same(array('SubDir Value', 'Sub Value'), export($root->getNearestChildren()));
});



// Get first filled (children)
$root->children = array();
$root->value = NULL;
$root->addChild('subdir/sub/sub', 'subdir/sub/sub value');
$root->addChild('subdir/subdir', 'subdir/subdir value');
$root->addChild('sub', 'sub value');

test(function() use ($root) {
	$node = $root->getFirstFilled();
	Assert::same('subdir/sub/sub value', $node->value);
});

