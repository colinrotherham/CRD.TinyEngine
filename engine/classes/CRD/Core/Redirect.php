<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Redirect
	{
		public function to($url, $permanent = false)
		{
			if ($permanent)
			{
				header('HTTP/1.1 301 Moved Permanently');
			}
		
			// Perform redirect
			header('Location: ' . $url); exit;
		}
	}
?>