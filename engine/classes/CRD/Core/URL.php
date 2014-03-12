<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class URL
	{
		public static $url = '';
		public static $components = array();

		public static function parse($url = '', $override = null)
		{
			self::$url = $url;
			self::$components = parse_url(self::$url);

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

							if (!array_key_exists($pair[0], $override['query']))
								$override['query'][$pair[0]] = !empty($pair[1])? $pair[1] : '';
						}
					}

					// New combined/replaced query string
					self::$components['query'] = http_build_query($override['query']);
				}

				// Override hash fragment
				if (!empty($override['fragment']))
					self::$components['fragment'] = $override['fragment'];
			}

			return self::build();
		}

		public static function build()
		{
			// Build URL
			$url = '';

			if (!empty(self::$components))
			{
				// Start with a scheme
				if (!empty(self::$components['host']))
					$url .= (!empty(self::$components['scheme'])? self::$components['scheme'] : 'http') . '://' . self::$components['host'];

				if (!empty(self::$components['path']))
					$url .= self::$components['path'];

				if (!empty(self::$components['query']))
					$url .= '?' . self::$components['query'];

				if (!empty(self::$components['fragment']))
					$url .= '#' . self::$components['fragment'];
			}

			return $url;
		}
	}
?>