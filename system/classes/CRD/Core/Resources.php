<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Resources
	{
		private $app;

		public $locale = '';
		public $locale_default = 'en-GB';

		// All resources will be populated here
		public $list = array();

		// The current/default locale's resources will be populated here
		public $resource = array();
		public $resource_default = array();

		public function __construct($app)
		{
			$this->app = $app;
		}

		// Set locale
		public function setLocale($locale = '')
		{
			// Use requested locale or fall back to default?
			$this->locale = (array_key_exists($locale, $this->list))?
				$locale : $this->locale_default;

			// Try to set chosen resource
			if (isset($this->list[$this->locale]))
				$this->resource = $this->list[$this->locale];

			// Try to set default resource
			if (isset($this->list[$this->locale_default]))
				$this->resource_default = $this->list[$this->locale_default];
		}
		
		// Get text string by key
		public function get($category, $key)
		{
			// Presume default locale if not yet set
			if (!isset($this->resource))
			{
				$this->setLocale($this->locale_default);
			}
		
			// Grab the locale's resource and category strings
			$resource = $this->resource;
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
				$resource = $this->resource_default;
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
		
		public function html($category, $key, $find_replaces = null)
		{
			$resource = $this->app->html->entities($this->get($category, $key));

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