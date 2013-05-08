<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class View
	{
		public $app;

		public $name;
		public $action;
		public $template;

		// Other helpers
		public $cache;

		// Shared array for passing from route action to view
		public $bag;
	
		public function __construct($app, $name, $action)
		{
			$this->app = $app;
			$this->name = $name;
			$this->action = $action;

			if (isset($this->name) && !file_exists($this->location()))
				throw new \Exception('Checking view: Missing view file');

			// Other helpers
			$this->cache = $this->app->cache;
			$this->file = new File($this->cache);

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
			{			
				// Inject file, from cache if possible
				$context = (object) array('name' => 'view', 'scope' => $this);
				$this->file->inject($this->location(), 'view-' . $this->name, $context);
			}
		}
	}
?>