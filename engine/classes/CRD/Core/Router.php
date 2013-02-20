<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Router
	{
		public $app;
		public $routes = array();

		public function __construct($app)
		{
			$this->app = $app;

			if (empty($_SERVER['REQUEST_URI']))
				throw new \Exception("Creating router: Can't access request URI");

			// Where are we?
			$this->route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		}

		// Build view + action for this route
		public function add($route, $view, $action = null)
		{
			if (!is_array($view) || empty($view[0]))
				throw new \Exception('Adding route: Invalid view array');

			$this->routes[$route] = new View($this->app, $view[0], $action);
		}

		public function view()
		{
			$view = (isset($this->routes[$this->route]))?
				$this->routes[$this->route] : null;
		
			return $view;
		}

		public function check()
		{
			if (empty($this->routes))
				throw new \Exception('Checking route: Missing routes table');

			$view = $this->view();

			// No view for this route
			if (empty($view))
			{
				header('Status: 404 Not Found', true, 404);

				// Check for special :404: route
				$this->route = ':404:';
				$view = $this->view();
			}

			// Render route action + view
			if (!empty($view))
				$view->render();
		}
	}
?>