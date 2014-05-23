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

		public $cache_enabled = true;
		public $cache_length = 3600;

		public $credentials;
		public $queries;

		// Other helpers
		public $router;
		public $cache;
		public $database;
		public $redirect;

		// App forms
		private $forms = array();

		public function __construct($path)
		{
			$this->path = $path;

			$this->credentials = (object) array();
			$this->queries = (object) array();
		}

		// Instantiate other helpers + inject app instance
		public function start()
		{
			$this->cache = new Cache($this->name, $this->cache_enabled, $this->cache_length);
			$this->database = new Database($this->credentials);
			$this->redirect = new Redirect();
		}

/*
		Form helper methods
		----------------------------------- */

		public function setForm($type, $model, $onSuccess = null, $onSubmit = null, $onPreSubmit = null)
		{
			// Add form to collection
			$form = new \CRD\Form\Helper($type, $model, $onSuccess, $onSubmit, $onPreSubmit);
			$this->forms[$type] = $form;

			return $form;
		}

		public function getForm($type)
		{
			$form = array_key_exists($type, $this->forms)?
				$this->forms[$type] : false;

			return $form;
		}
	}