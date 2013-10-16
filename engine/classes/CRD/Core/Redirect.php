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

		public static function to($url, $is_permanent = false, $params = array())
		{
			// Which status code?
			$status = ($is_permanent)? self::$permanent : self::$temporary;
			$components = parse_url($url);

			// Add query string params
			if (!empty($params))
			{
				if (!empty($components['query']))
				{
					// Extract current query
					$query = explode('&', html_entity_decode($components['query']));

					// Add/Replace to $params
					foreach($query as $pair)
					{
						$pair = explode('=', $pair);

						if (!array_key_exists($pair[0], $params))
							$params[$pair[0]] = $pair[1];
					}
				}

				// New combined/replaced query string
				$components['query'] = http_build_query($params);
			}

			$url = '';

			// Start with a scheme
			if (!empty($components['host']))
				$url .= (!empty($components['scheme'])? $components['scheme'] : 'http') . '://' . $components['host'];

			if (!empty($components['path']))
				$url .= $components['path'];

			if (!empty($components['query']))
				$url .= '?' . $components['query'];

			if (!empty($components['fragment']))
				$url .= '#' . $components['fragment'];

			// Perform redirect
			header('Location: ' . $url, true, $status);
			exit;
		}
	}
?>