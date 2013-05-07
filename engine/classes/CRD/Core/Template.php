<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Template
	{
		public $app;
		public $cache;
	
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
		public $html;
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
				if (file_exists($this->location($partial, true)))
				{
					// Insert partial content into buffer
					$this->contentPartial($partial);
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
			// Pull partial from cache, save disk IO
			$partial_file = $this->location($partial, true);
			$partial_content = $this->cache->get('partial-' . $partial);

			// Include file if not cached
			if (!$partial_content)
			{
				// Cache for next time + inject content
				$this->cache->set('partial-' . $partial, file_get_contents($partial_file));
				require_once ($partial_file);
			}
			
			// Output from cache and run as PHP
			else eval('?>' . $partial_content);
		}
		
		public function content($name, $return = false)
		{
			$content = (!empty($this->buffer[$name]))? $this->buffer[$name]: '';
			
			if (!$return) echo $content;
			else return $content;
		}

		public function location($name, $is_partial = false)
		{
			if (empty($name))
				$name = $this->name;
		
			return $this->app->path . (($is_partial)? '/views/partials/' : '/templates/') . $name . '.php';
		}

		public function render()
		{
			if (!empty($this->placeholder))
				$this->placeHolderEnd();

			// Pull template from cache, save disk IO
			$template_content = $this->cache->get('template-' . $this->name);

			// Include file if not cached
			if (!$template_content)
			{
				// Cache for next time + inject content
				$this->cache->set('template-' . $this->name, file_get_contents($this->template));
				require_once ($this->template);
			}
			
			// Output from cache and run as PHP
			else eval('?>' . $template_content);
		}
	}
?>