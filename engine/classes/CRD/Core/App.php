<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class App
	{
		// Other helpers
		public $cache;
		public $database;
		public $html;
		public $redirect;
		public $resource;
		public $template;

		public $path = '';
		public $version = '';
		public $name = '';
		public $templates = array();
		public $partials = array();

		public $cache_enabled = true;
		public $cache_length = 3600;

		public $credentials;
		public $queries;

		public $debug = false;

		public function __construct($path = '')
		{
			$this->credentials = (object) array();
			$this->queries = (object) array();

			// Set path
			$this->path = $path;

			// Instantiate other helpers + inject app instance
			$this->cache = new Cache($this);
			$this->database = new Database($this);
			$this->html = new HTML($this);
			$this->redirect = new Redirect($this);
			$this->resources = new Resources($this);
		}
	}