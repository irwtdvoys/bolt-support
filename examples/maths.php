<?php
	use Bolt\Maths;

	require_once(__DIR__ . "/../vendor/autoload.php");

	function output($title, $value)
	{
		echo($title . ":" . PHP_EOL);
		var_dump($value);
		echo(PHP_EOL);
	}

	// Initialise data set
	$data = array();

	$max = 10;

	while (count($data) < $max)
	{
		$data[] = rand(0, 10);
	}

	echo("Data Set: " . PHP_EOL . json_encode($data) . PHP_EOL . PHP_EOL);

	output("Mean", Maths::mean($data));
	output("Median", Maths::median($data));
	output("Mode", Maths::mode($data));
?>
