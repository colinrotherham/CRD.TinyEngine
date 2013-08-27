<?php

/*
	Application config
	----------------------------------- */

	namespace CRD\Core;

	// Default timezone
	date_default_timezone_set('Europe/London');

	// Start the app
	$app = new App($path);

	// App name, also cache prefix
	$app->name = 'Tiny Engine';

	// Set app version string
	$app->version = '1.0';

	// Add queries config
	require_once ($path . '/config.queries.php');
?>