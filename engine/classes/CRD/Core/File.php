<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class File
	{
		private $cache;
		private $template;

		public function __construct($cache, $template = null)
		{
			$this->cache = $cache;
			$this->template = $template;
		}

		public function inject($file, $name, $context = null)
		{
			// Set magic scope
			if (is_object($context) && !empty($context->name) && !empty($context->scope))
				${$context->name} = $context->scope;

			// Pull content from cache, saves disk IO
			$content = $this->cache->get($name);

			// Include file if not cached
			if (!$content)
			{
				// Cache for next time + inject content
				$this->cache->set($name, file_get_contents($file));
				require ($file);
			}

			// Output from cache and run as PHP
			else eval('?>' . $content);
		}
	}
?>