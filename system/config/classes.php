<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	// Where are we?
	$path = realpath(getcwd() . '/../');

	// Include class auto-loader
	require_once ($path . '/system/classes/SplClassLoader.php');

	// Start auto-loader
	$loader = new \SplClassLoader();
	$loader->register();

	// Save root path into app config
	$app = new App($path);

	// Include resources
	foreach (glob($path . '/resources/*.php') as $resource_filename)
		require_once ($resource_filename);

	// Include other configs
	require_once ($path . '/system/config/config.php');
	require_once ($path . '/system/config/queries.php');
?>