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

		private static $components = array();

		// Redirect to a URL, optionally override URL components
		public static function to($url, $is_permanent = false, $override = array())
		{
			// Which status code?
			$status = ($is_permanent)? self::$permanent : self::$temporary;

			// Split out URL components
			self::$components = self::parse($url, $override);

			// Perform redirect
			header('Location: ' . self::build(), true, $status);
			exit;
		}

		public static function build()
		{
			// Build URL
			$url = '';

			// Start with a scheme
			if (!empty(self::$components['host']))
				$url .= (!empty(self::$components['scheme'])? self::$components['scheme'] : 'http') . '://' . self::$components['host'];

			if (!empty(self::$components['path']))
				$url .= self::$components['path'];

			if (!empty(self::$components['query']))
				$url .= '?' . self::$components['query'];

			if (!empty(self::$components['fragment']))
				$url .= '#' . self::$components['fragment'];

			return $url;
		}

		public static function parse($url, $override)
		{
			self::$components = parse_url($url);

			if (is_array($override))
			{
				// Override query string params
				if (!empty($override['query']))
				{
					// Combine with existing params
					if (!empty(self::$components['query']))
					{
						// Extract current query
						$query = explode('&', html_entity_decode(self::$components['query']));

						// Add/Replace to $override
						foreach($query as $pair)
						{
							$pair = explode('=', $pair);

							if (!array_key_exists($pair[0], $override))
								$override['query'][$pair[0]] = $pair[1];
						}
					}

					// New combined/replaced query string
					self::$components['query'] = http_build_query($override['query']);
				}

				// Override hash fragment
				if (!empty($override['fragment']))
					self::$components['fragment'] = $override['fragment'];
			}

			return self::$components;
		}
	}
?>