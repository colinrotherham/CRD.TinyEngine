<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	// Where are we?
	$path = (isset($path))? $path : realpath(getcwd() . '/../');

	// Include class auto-loader
	require_once ($path . '/engine/classes/SplClassLoader.php');

	// Start auto-loader
	$loader = new \SplClassLoader();
	$loader->register();

	// Include main config + routes
	require_once ($path . '/config.php');

	// Init app
	$app->start();

	// Start web router when not running on CLI
	if (PHP_SAPI !== 'cli')
		require_once ($path . '/config.routes.php');
?>