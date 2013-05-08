<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Template
	{
		public $app;
	
		public $view;
		public $path;

		public $page = '';
		public $title = '';
		public $meta = '';
		public $canonical = '';

		// Template name and current placeholder
		private $name = '';
		private $placeholder = '';

		// Store this template's PHP file name
		private $template;

		// Array of content by placeholder name
		private $buffer = array();

		// Other helpers
		public $cache;
		public $html;
		public $file;
		public $resources;

		public function __construct($view, $name, $page = '')
		{
			$this->view = $view;
			$this->name = $name;
			$this->page = $page;

			if (empty($this->view))
				throw new \Exception("Creating template: Missing view name");

			// Pull app and cache helper from view
			$this->app = $this->view->app;
			$this->cache = $this->app->cache;

			if (empty($this->name))
				throw new \Exception("Creating template: Missing template name");

			else if (!file_exists($this->location()))
				throw new \Exception('Checking template: Missing template file');

			// Store template for later
			$this->template = $this->location();

			// Other helpers
			$this->html = new HTML($this);
			$this->file = new File($this->cache, $this);
			$this->resources = new Resources($this, $this->view->app->path);
		}
		
		public function __destruct()
		{
			$this->render();
		}
		
		public function placeHolder($name, $content = null, $partial = null, $partial_shared = null)
		{
			$this->placeholder = $name;
			$this->buffer[$this->placeholder] = '';

			// Auto-assign content
			if (!empty($content))
			{
				$this->buffer[$this->placeholder] = $content;
				$this->placeHolderEnd();
				return;
			}

			// Start buffering page content
			ob_start();

			// Partial name provided
			if (!empty($partial))
			{
				// Partial exists in config?
				if (file_exists($this->location($partial, true)))
				{
					// Insert partial content into buffer
					$this->contentPartial($partial, $partial_shared);
					$this->placeHolderEnd();
				}
				
				else throw new \Exception("Missing partial: '{$partial}'");
			}
		}
		
		public function placeHolderEnd()
		{
			// Spit the buffer into $content
			if (empty($this->buffer[$this->placeholder]))
			{
				$this->buffer[$this->placeholder] = ob_get_contents();
				$this->placeholder = '';

				// Clear down the buffer
				ob_end_clean();
			}
		}
		
		public function placeHolderPartial($name, $partial, $shared = null)
		{
			$this->placeHolder($name, null, $partial, $shared);
		}
		
		public function contentPartial($partial, $shared = null)
		{
			// Inject file, from cache if possible
			$context = (!empty($shared))? (object) array('name' => 'shared', 'scope' => $shared) : null;
			$this->file->inject($this->location($partial, true), 'partial-' . $partial, $context);
		}
		
		public function content($name, $return = false)
		{
			$content = (!empty($this->buffer[$name]))? $this->buffer[$name]: '';
			
			if (!$return) echo $content;
			else return $content;
		}

		public function location($name = '', $is_partial = false)
		{
			if (empty($name))
				$name = $this->name;
		
			return $this->app->path . (($is_partial)? '/views/partials/' : '/templates/') . $name . '.php';
		}

		public function render()
		{
			if (!empty($this->placeholder))
				$this->placeHolderEnd();

			// Inject file, from cache if possible
			$context = (object) array('name' => 'template', 'scope' => $this);
			$this->file->inject($this->template, 'template-' . $this->name, $context);
		}
	}
?>