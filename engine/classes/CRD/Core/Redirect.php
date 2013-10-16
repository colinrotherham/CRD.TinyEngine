<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Redirect
	{
		private static $permanent = 301;
		private static $temporary = 302;

		public static function to($url, $is_permanent = false)
		{
			// Which status code?
			$status = ($is_permanent)? self::$permanent : self::$temporary;

			// Perform redirect
			header('Location: ' . $url, true, $status);
			exit;
		}
	}
?>