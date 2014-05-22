<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Redirect extends URL
	{
		private static $permanent = 301;
		private static $temporary = 302;

		// Redirect to a URL, optionally override URL components
		public static function to($url, $is_permanent = false, $override = array())
		{
			// Which status code?
			$status = ($is_permanent)? self::$permanent : self::$temporary;

			// Perform redirect
			header('Location: ' . self::parse($url, $override), true, $status);
			exit;
		}
	}
?>