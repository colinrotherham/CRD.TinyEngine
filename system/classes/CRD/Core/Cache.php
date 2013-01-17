<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Cache
	{
		public static function get($cache_name)
		{
			$success = false;
			$cache_value = null;

			if (function_exists('apc_fetch') && App::$cache_enabled)
			{
				$cache_value = apc_fetch(App::$name . ' ' . $cache_name, $success);
				if ($success) return $cache_value;
			}
			
			return false;
		}

		public static function set($cache_name, $cache_value)
		{
			if (function_exists('apc_store') && App::$cache_enabled)
			{
				return apc_store(App::$name . ' ' . $cache_name, $cache_value, App::$cache_length);
			}
			
			return false;
		}
		
		public static function delete($cache_name)
		{
			if (function_exists('apc_delete') && App::$cache_enabled)
			{
				return apc_delete(App::$name . ' ' . $cache_name);
			}
			
			return false;
		}
		
		public static function clear()
		{
			apc_clear_cache('user');
		}
	}
?>