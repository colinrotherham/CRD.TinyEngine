<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class View
	{
		public $app;
		public $cache;

		public $name;
		public $action;
		public $template;

		// Shared array for passing from route action to view
		public $bag;
	
		public function __construct($app, $name, $action)
		{
			$this->app = $app;
			$this->name = $name;
			$this->action = $action;

			if (empty($this->name))
				throw new \Exception('Creating view: Missing view name');

			else if (!file_exists($this->location()))
				throw new \Exception('Checking view: Missing view file');

			// Provide caching helper
			$this->cache = $this->app->cache;

			// Make view bag an object
			$this->bag = (object) array();
		}
		
		public function location()
		{
			return $this->app->path . '/views/' . $this->name . '.php';
		}
		
		public function render()
		{
			// Run controller action
			if (is_callable($this->action))
			{
				$action = $this->action;
				$action($this);
			}

			// Present view if provided
			if (!empty($this->name))
				require_once ($this->location());
		}
	}
?>