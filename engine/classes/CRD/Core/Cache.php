<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Cache
	{
		private $name;
		private $cache_enabled;
		private $cache_length;

		public function __construct($name, $cache_enabled, $cache_length)
		{
			$this->name = $name;
			$this->cache_enabled = $cache_enabled;
			$this->cache_length = $cache_length;
		}
	
		public function get($cache_name)
		{
			$success = false;
			$cache_value = null;

			if (function_exists('apc_fetch') && $this->cache_enabled)
			{
				$cache_value = apc_fetch($this->name . ' ' . $cache_name, $success);
				if ($success) return $cache_value;
			}
			
			return false;
		}

		public function set($cache_name, $cache_value)
		{
			if (function_exists('apc_store') && $this->cache_enabled)
			{
				return apc_store($this->name . ' ' . $cache_name, $cache_value, $this->cache_length);
			}
			
			return false;
		}
		
		public function delete($cache_name)
		{
			if (function_exists('apc_delete') && $this->cache_enabled)
			{
				return apc_delete($this->name . ' ' . $cache_name);
			}
			
			return false;
		}
		
		public function clear()
		{
			apc_clear_cache('user');
		}
	}
?>