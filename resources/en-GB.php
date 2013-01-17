<?php
	use \CRD\Core\Resource as Resource;

	// Start new resource
	Resource::$resources['en-GB'] = array();

	// Shared resources
	Resource::$resources['en-GB']['Shared'] = array
	(
		'Go to'			=> 'Go to'
	);

	// Home page resources
	Resource::$resources['en-GB']['Home'] = array
	(
		'Heading'		=> 'Home',
		'Intro'			=> 'Hello chaps, welcome to the tiny engine demo'
	);
	
	// Shared resources
	Resource::$resources['en-GB']['Contact Us'] = array
	(
		'Heading'			=> 'Contact Us',
		'Telephone'			=> 'Telephone',
		'Telephone Number'	=> '07792348487',
		'Address Line 1'	=> '240 Park Lane',
		'Address Line 2'	=> '',
		'Town'				=> 'Poynton',
		'County'			=> 'Cheshire',
		'Postcode'			=> 'SK12 1RQ',
		'Contact Us'		=> 'Contact Us'
	);
?>