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

		// Store cache methods (allows switching to APCu)
		private $methods;

		public function __construct($prefix, $enabled, $length)
		{
			$this->prefix = $prefix;
			$this->enabled = $enabled;
			$this->length = $length;

			// No need to continue if disabled
			if (!$this->enabled)
				return;

			// Default APC methods
			$this->methods = (object) array
			(
				'get'		=> 'apc_fetch',
				'set'		=> 'apc_store',
				'delete'	=> 'apc_delete',
				'clear'		=> 'apc_clear_cache'
			);

			// Check for APC
			foreach ($this->methods as &$method)
			{
				$alternative = str_replace('apc_', 'apcu_', $method);

				// APC exists
				if (function_exists($method))
					continue;

				// APCu exists
				else if (function_exists($alternative))
					$method = $alternative;

				// Disable caching
				else $this->enabled = false;
			}
		}

		public function get($name)
		{
			$success = false;
			$value = null;

			if ($this->enabled)
				$value = call_user_func_array($this->methods->get, array("{$this->prefix} {$name}", &$success));

			return ($success)? $value : false;
		}

		public function set($name, $value)
		{
			$success = false;

			if ($this->enabled)
				$success = call_user_func_array($this->methods->set, array("{$this->prefix} {$name}", $value, $this->length));

			return $success;
		}

		public function delete($name)
		{
			$success = false;

			if ($this->enabled)
				$success = call_user_func_array($this->methods->delete, array("{$this->prefix} {$name}"));

			return $success;
		}

		public function clear()
		{
			if ($this->enabled)
				call_user_func($this->methods->clear);
		}
	}
?>