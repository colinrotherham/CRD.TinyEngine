<?php

/*
	Routing table
	----------------------------------- */

	namespace CRD\Core;

	// Start router
	$app->router = new Router($app, $path);

	// Home
	$app->router->add('/', 'home', function($view)
	{
		$view->template = new Template($view, 'page', 'page-home');
	});

	// Contact Us
	$app->router->add('/contact/', 'contact', function($view)
	{
		$view->template = new Template($view, 'page', 'page-contact');
	});

	// Check request matches a route
	$app->router->check();
?>