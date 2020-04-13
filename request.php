<?php

	require_once('autoload.php');

	$output = [
		'status' => 200,
		'data' => []
	];

	$controller = $_GET['controller'];
	$function = $_GET['function'];
	
	$class = new $controller;
	$output['data'] = $class->{$function}(json_decode(file_get_contents('php://input'), true));

	echo json_encode($output);