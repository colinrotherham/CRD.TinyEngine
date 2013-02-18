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

	// Include main config
	require_once ($path . '/config.php');

	// Include resources
	foreach (glob($path . '/resources/*.php') as $resource_filename)
		require_once ($resource_filename);

	// Assume default locale for now (may be overridden later)
	$app->resources->setLocale();
?>