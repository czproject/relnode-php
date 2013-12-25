<?php
require __DIR__ . '/../../vendor/nette/tester/Tester/bootstrap.php';

if (extension_loaded('xdebug'))
{
	Tester\CodeCoverage\Collector::start(__DIR__ . '/../coverage.dat');
}

function test(\Closure $function)
{
	$function();
}




function export(array $nodes)
{
	$values = array();

	foreach($nodes as $node)
	{
		$values[] = $node->value;
	}

	return $values;
}

