<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Cache
	{
		private $app;

		public function __construct($app)
		{
			$this->app = $app;
		}
	
		public function get($cache_name)
		{
			$success = false;
			$cache_value = null;

			if (function_exists('apc_fetch') && $this->app->cache_enabled)
			{
				$cache_value = apc_fetch($this->app->name . ' ' . $cache_name, $success);
				if ($success) return $cache_value;
			}
			
			return false;
		}

		public function set($cache_name, $cache_value)
		{
			if (function_exists('apc_store') && $this->app->cache_enabled)
			{
				return apc_store($this->app->name . ' ' . $cache_name, $cache_value, $this->app->cache_length);
			}
			
			return false;
		}
		
		public function delete($cache_name)
		{
			if (function_exists('apc_delete') && $this->app->cache_enabled)
			{
				return apc_delete($this->app->name . ' ' . $cache_name);
			}
			
			return false;
		}
		
		public function clear()
		{
			apc_clear_cache('user');
		}
	}
?>