<?php
	require_once("../vendor/autoload.php");

	function output($title, $value)
	{
		echo($title . ":\n");
		var_dump($value);
		echo("\n");
	}

	// Initialise data set
	$data = array();

	$max = 10;

	while (count($data) < $max)
	{
		$data[] = rand(0, 10);
	}

	echo("Data Set: \n" . json_encode($data) . "\n\n");

	output("Mean", \Bolt\Maths::mean($data));
	output("Median", \Bolt\Maths::median($data));
	output("Mode", \Bolt\Maths::mode($data));
?>
