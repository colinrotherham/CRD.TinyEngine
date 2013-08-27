<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Resources
	{
		public $locale = '';
		public $locale_default = 'en-GB';

		// All resources will be populated here
		public $list = array();

		// The current/default locale's resources will be populated here
		public $resource = array();
		public $resource_default = array();

		// Other helpers
		private $cache;
		private $helper;
		private $file;

		public function __construct($template, $cache)
		{
			$this->helper = $template->html;
			$this->file = new File($cache, $template);

			// Grab all resource files
			$resources = glob($template->path . '/resources/*.php');

			// Loop resource filenames
			if (!empty($resources)) foreach ($resources as $file)
			{
				$info = pathinfo($file);
				$name = basename($file, '.' . $info['extension']);

				// Inject from cache if possible
				$context = (object) array('name' => 'resources', 'scope' => $this);
				$this->file->inject($file, 'resource-' . $name, $context);
			}

			// Assume default locale for now (may be overridden later)
			$this->setLocale();
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
				else throw new \Exception("Missing '{$key}' resource");
			}

			return $string;
		}

		public function html($category, $key, $find_replaces = null)
		{
			$resource = $this->helper->entities($this->get($category, $key));

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