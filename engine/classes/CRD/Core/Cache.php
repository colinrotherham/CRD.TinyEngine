<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Cache
	{
		private $prefix;
		private $enabled;
		private $length;

		public function __construct($prefix, $enabled, $length)
		{
			$this->prefix = $prefix;
			$this->enabled = $enabled;
			$this->length = $length;
		}

		public function get($name)
		{
			$success = false;
			$value = null;

			if (function_exists('apc_fetch') && $this->enabled)
				$value = apc_fetch("{$this->prefix} {$name}", $success);

			return ($success)? $value : false;
		}

		public function set($name, $value)
		{
			$success = false;

			if (function_exists('apc_store') && $this->enabled)
				$success = apc_store("{$this->prefix} {$name}", $value, $this->length);

			return $success;
		}

		public function delete($name)
		{
			$success = false;

			if (function_exists('apc_delete') && $this->enabled)
				$success = apc_delete("{$this->prefix} {$name}");

			return $success;
		}

		public function clear()
		{
			apc_clear_cache('user');
		}
	}
?>