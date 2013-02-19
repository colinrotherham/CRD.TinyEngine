<?php

/*
	Application config
	----------------------------------- */

	namespace CRD\Core;

	// Default timezone
	date_default_timezone_set('Europe/London');

	// Start the app
	$app = new App();

	// App name, also cache prefix
	$app->name = 'Tiny Engine';
	
	// Set app version string
	$app->version = '1.0';

	// Page templates
	$app->templates = array
	(
		'page'		=> '/templates/template-page.php'
	);
	
	// Page partials
	$app->partials = array
	(
		'address'	=> '/views/partials/partial-address.php'
	);

	// Add queries config
	require_once ($path . '/config.queries.php');
?>