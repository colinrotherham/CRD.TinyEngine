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
	
		public $name = '';
		public $title = '';
		public $meta = '';
		public $canonical = '';

		// Template and current placeholder
		private $template = '';
		private $placeholder = '';

		// Array of content by placeholder name
		private $buffer = array();

		// Other helpers
		public $html;
		public $resources;

		public function __construct($view, $template, $name = '')
		{
			$this->view = $view;
			$this->template = $template;
			$this->name = $name;

			if (empty($this->view))
				throw new \Exception("Creating template: Missing view name");

			// For template includes, pull app from view
			$this->app = $this->view->app;

			if (empty($this->template))
				throw new \Exception("Creating template: Missing template name");

			else if (!file_exists($this->location()))
				throw new \Exception('Checking template: Missing template file');

			// Other helpers
			$this->html = new HTML($this);
			$this->resources = new Resources($this, $this->view->app->path);
		}
		
		public function __destruct()
		{
			$this->render();
		}
		
		public function placeHolder($name, $content = null, $partial = null)
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
				if (isset($this->view->partials[$partial]))
				{
					// Insert partial content into buffer
					require_once ($this->app->path . '/' . $this->view->partials[$partial]);

					// End placeholder, i.e. close buffer
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
		
		public function placeHolderPartial($name, $partial)
		{
			$this->placeHolder($name, null, $partial);
		}
		
		public function contentPartial($partial, $shared = null)
		{
			// Inject content
			require_once ($this->app->path . '/' . $this->view->partials[$partial]);
		}
		
		public function content($name, $return = false)
		{
			$content = (!empty($this->buffer[$name]))? $this->buffer[$name]: '';
			
			if (!$return) echo $content;
			else return $content;
		}

		public function location()
		{
			return $this->app->path . '/templates/' . $this->template . '.php';
		}

		public function render()
		{
			if (!empty($this->placeholder))
			{
				$this->placeHolderEnd();
			}

			// Pull template from cache, save disk IO
			$template_content = $this->view->cache->get('template-' . $this->template);

			// Include file if not cached
			if (!$template_content)
			{
				// Attempt to cache
				$this->view->cache->set('template-' . $this->template, file_get_contents($this->location()));
			
				// Load the template
				require_once ($this->location());
			}
			
			// Output from cache and run as PHP
			else
			{
				eval('?>' . $template_content);
			}
		}
	}
?>