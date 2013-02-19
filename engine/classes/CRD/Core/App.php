<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class App
	{
		public $path;
	
		public $version = '';
		public $name = '';
		public $templates = array();
		public $partials = array();

		public $cache_enabled = true;
		public $cache_length = 3600;

		public $credentials;
		public $queries;

		// Other helpers
		public $router;
		public $cache;
		public $database;
		public $redirect;

		public function __construct($path)
		{
			$this->path = $path;
		
			$this->credentials = (object) array();
			$this->queries = (object) array();

			// Instantiate other helpers + inject app instance
			$this->cache = new Cache($this->name, $this->cache_enabled, $this->cache_length);
			$this->database = new Database($this->credentials);
			$this->redirect = new Redirect();
		}
	}