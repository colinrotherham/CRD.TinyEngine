<?php
	namespace CRD\Core;

	$resources = &$app->resources->list;

	// Start new resource
	$resources['en-US'] = array();
	
	// Home page resources
	$resources['en-US']['Home'] = array
	(
		'Intro'			=> 'Hey guys, check out the tiny engine demo'
	);
?>