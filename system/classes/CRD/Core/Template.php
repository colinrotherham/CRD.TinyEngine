<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Template
	{
		public $app;
	
		public $name = '';
		public $title = '';
		public $meta = '';
		public $canonical = '';

		// Template and current placeholder
		private $template = '';
		private $placeholder = '';
		
		// Array of content by placeholder name
		private $buffer = array();

		public function __construct($app, $template, $name = '')
		{
			$this->app = $app;
			$this->template = $template;
			$this->name = $name;
		}
		
		public function __destruct()
		{
			if (isset($this->app->templates[$this->template]))
			{
				$this->render();
			}
			
			else
			{
				error_log("Missing template: '$template'");
			}
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

			if (!empty($partial))
			{
				// Insert partial content into buffer
				require_once ($this->app->path . '/' . $this->app->partials[$partial]);
				
				// End placeholder, i.e. close buffer
				$this->placeHolderEnd();
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
			require_once ($this->app->path . '/' . $this->app->partials[$partial]);
		}
		
		public function content($name, $return = false)
		{
			$content = (!empty($this->buffer[$name]))? $this->buffer[$name]: '';
			
			if (!$return) echo $content;
			else return $content;
		}

		public function render()
		{
			if (!empty($this->placeholder))
			{
				$this->placeHolderEnd();
			}

			// Pull template from cache, save disk IO
			$template_content = $this->app->cache->get('template-' . $this->template);

			// Include file if not cached
			if (!$template_content)
			{
				$template_file = $this->app->path . '/' . $this->app->templates[$this->template];

				// Attempt to cache
				$this->app->cache->set('template-' . $this->template, file_get_contents($template_file));
			
				// Load the template
				require_once ($template_file);
			}
			
			// Output from cache and run as PHP
			else
			{
				eval('?>' . $template_content);
			}
		}
	}
?>