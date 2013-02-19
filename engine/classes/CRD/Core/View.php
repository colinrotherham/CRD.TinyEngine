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

		// All templates and partials
		public $templates = array();
		public $partials = array();

		// Shared array for passing from route action to view
		public $bag = array();
	
		public function __construct($app, $name, $action)
		{
			$this->app = $app;
			$this->name = $name;
			$this->action = $action;

			// Allow views to access templates/partials
			$this->templates = $app->templates;
			$this->partials = $app->partials;
			
			// Provide caching helper
			$this->cache = $app->cache;
		}
		
		public function render()
		{
			// Run controller action
			if (is_callable($this->action))
			{
				$action = $this->action;
				$action($this);
			}

			// Present view
			require_once ($this->app->path . '/views/view-' . $this->name . '.php');
		}
	}
?>