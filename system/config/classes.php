<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	use \CRD\Core\App as App;

	// Where are we?
	$path = realpath(getcwd() . '/../');

	// Include class auto-loader
	require_once ($path . '/system/classes/SplClassLoader.php');

	// Start auto-loader
	$loader = new SplClassLoader();
	$loader->register();

	// Include resources
	foreach (glob($path . '/resources/*.php') as $resource_filename)
		require_once ($resource_filename);

	// Save root path into app config
	App::$path = $path;
	App::init();

	// Include other configs
	require_once ($path . '/system/config/config.php');
	require_once ($path . '/system/config/queries.php');
?>