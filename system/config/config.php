<?php

/*
	Application config
	----------------------------------- */

	use \CRD\Core\App as App;
	use \CRD\Core\Resource as Resource;

	// Default timezone
	date_default_timezone_set('Europe/London');

	// App name, also cache prefix
	App::$name = 'Tiny Engine';
	
	// Set app version string
	App::$version = '1.0';

	// Page templates
	App::$templates = array
	(
		'page'		=> '/templates/template-page.php'
	);
	
	// Page partials
	App::$partials = array
	(
		'address'	=> '/views/partials/partial-address.php'
	);

	// Set up locale
	Resource::locale('en-GB');
?>