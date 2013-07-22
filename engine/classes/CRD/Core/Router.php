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

		public $route;
		public $directory;

		public function __construct($app)
		{
			$this->app = $app;

			if (empty($_SERVER['REQUEST_URI']) || empty($_SERVER['DOCUMENT_ROOT']))
				throw new \Exception("Creating router: Can't access request URI or document root");

			$root = preg_quote($_SERVER['DOCUMENT_ROOT'], '/');

			// Where are we?
			$this->directory = parse_url(preg_replace("/^{$root}/", '', $this->app->path), PHP_URL_PATH);
			$this->route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

			// Remove directory from route?
			if (!empty($this->directory) && strpos($this->route, $this->directory) === 0)
				$this->route = substr($this->route, strlen($this->directory));
		}

		// Build view + action for this route
		public function add($name, $route, $config = null, $action = null)
		{
			$file = null;

			// Extract view filename from config array
			if (is_array($config))
			{
				if (empty($config['view']))
					throw new \Exception('Adding route: Missing view filename');

				// Extract view filename from array
				$file = $config['view'];
			}

			$this->routes[$name] = (object) array('path' => $route, 'view' => new View($this->app, $file, $action));
		}

		public function view($path = '')
		{
			if (empty($path))
				$path = $this->route;

			// Grab view by name, empty if 404
			$name = $this->nameByPath($path);
			$view = (!empty($name))? $this->routes[$name]->view : null;

			return $view;
		}

		public function path($name = '')
		{
			if (!isset($this->routes[$name]))
				throw new \Exception('Finding route by name: No matching view object found');

			return $this->directory . $this->routes[$name]->path;
		}

		public function nameByPath($path)
		{
			$cache = $this->app->cache;
			$cache_name = 'view-name-by-path-' . $path;

			// Retrieve view from cache
			$name = $cache->get($cache_name);

			// Scan route table
			if (!$name) foreach ($this->routes as $route_name => $route)
			{
				if ($route->path === $path || empty($route->path) && $route_name === $path)
				{
					// Add to cache
					$cache->set($cache_name, $route_name);

					// Use this name
					$name = $route_name;
					break;
				}
			}

			// Do still have no name?
			if (!$name) $name = '';

			return $name;
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

		public function is_ajax()
		{
			return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')? true : false;
		}
	}
?>