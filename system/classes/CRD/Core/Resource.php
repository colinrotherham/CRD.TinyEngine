<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Resource
	{
		public static $locale = '';
		public static $locale_default = 'en-GB';
		
		// All resources will be populated here
		public static $resources = array();
		
		// The current/default locale's resources will be populated here
		public static $resource;
		public static $resource_default;
		
		// Set locale
		public static function locale($locale)
		{
			// Use requested locale or fall back to default?
			self::$locale = (array_key_exists($locale, self::$resources))?
				$locale : self::$locale_default;

			// Try to set chosen resource
			if (isset(self::$resources[self::$locale]))
				self::$resource = self::$resources[self::$locale];

			// Try to set default resource
			if (isset(self::$resources[self::$locale_default]))
				self::$resource_default = self::$resources[self::$locale_default];
		}
		
		// Get text string by key
		public static function get($category, $key)
		{
			// Presume default locale if not yet set
			if (!isset(self::$resource))
			{
				self::locale(self::$locale_default);
			}			
		
			// Grab the locale's resource and category strings
			$resource = self::$resource;
			$strings = (array_key_exists($category, $resource))? $resource[$category] : array();
			
			// Store the final resource string here
			$string = '';

			// Does string exist for chosen locale?		
			if (array_key_exists($key, $strings))
			{
				$string = $strings[$key];
			}

			// Fall back to default
			else
			{
				// Grab the default locale's resource and category strings
				$resource = self::$resource_default;
				$strings = (array_key_exists($category, $resource))? $resource[$category] : array();

				// Does string exist for default locale?
				if (array_key_exists($key, $strings))
				{
					$string = $strings[$key];
				}
				
				// Oh dear, can't find this one
				else error_log("Missing '{$key}' resource");
			}

			return $string;
		}
		
		public static function html($category, $key, $find_replaces = null)
		{
			$resource = HTML::entities(self::get($category, $key));

			if ($find_replaces) foreach ($find_replaces as $find_replace)
			{
				$find = $find_replace[0];
				$replace = $find_replace[1];

				$resource = str_replace($find, $replace, $resource);
			}

			return $resource;
		}
	}
?>