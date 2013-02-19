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
				throw new \Exception("Route error: Can't access request URI");

			// Where are we?
			$this->route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		}

		// Build view + action for this route
		public function add($route, $view, $action = null)
		{
			$this->routes[$route] = new View($this->app, $view, $action);
		}

		public function check()
		{
			if (empty($this->routes))
				throw new \Exception('Missing routes table');

			$view = (isset($this->routes[$this->route]))?
				$this->routes[$this->route] : null;

			// No view for this route
			if (empty($view))
			{
				/* 404 */
			}

			// Render route action + view
			else $view->render();
		}
	}
?>