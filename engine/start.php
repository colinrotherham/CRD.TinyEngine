<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	// Where are we?
	$path = realpath(getcwd() . '/../');

	// Include class auto-loader
	require_once ($path . '/engine/classes/SplClassLoader.php');

	// Start auto-loader
	$loader = new \SplClassLoader();
	$loader->register();

	// Include main config + routes
	require_once ($path . '/config.php');
	require_once ($path . '/config.routes.php');
?>