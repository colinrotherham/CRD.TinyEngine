<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Redirect
	{
		private $app;

		public function __construct($app)
		{
			$this->app = $app;
		}

		public function to($url, $permanent = false)
		{
			if ($permanent)
			{
				header('HTTP/1.1 301 Moved Permanently');
			}
		
			// Perform redirect to login page
			header('Location: ' . $url); exit;
		}
	}
?>