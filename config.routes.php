<?php

/*
	Routing table
	----------------------------------- */

	namespace CRD\Core;

	// Start router
	$app->router = new Router($app, $path);

	// Home
	$app->router->add('/', array('home'), function($view)
	{
		$view->template = new Template($view, 'template-page', 'page-home');
	});

	// Contact Us
	$app->router->add('/contact/', array('contact'), function($view)
	{
		$view->template = new Template($view, 'template-page', 'page-contact');
	});

	// 404 route
	$app->router->add(':404:', array('error-404'), function($view)
	{
		$view->template = new Template($view, 'template-page', 'page-error');
	});

	// Check request matches a route
	$app->router->check();
?>