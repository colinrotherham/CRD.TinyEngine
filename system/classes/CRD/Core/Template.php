<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Template
	{
		public static $name = '';
		public static $title = '';
		public static $meta = '';
		public static $canonical = '';

		// Template and current placeholder
		private static $template = '';
		private static $placeholder = '';
		
		// Array of content by placeholder name
		private static $buffer = array();

		public static function create($template, $name = '')
		{
			self::$template = $template;
			self::$name = $name;

			// Render when finished
			register_shutdown_function(array(__CLASS__, 'render'));
		}
		
		public static function placeHolder($name, $content = null, $partial = null)
		{
			self::$placeholder = $name;
			self::$buffer[self::$placeholder] = '';

			// Auto-assign content
			if (!empty($content))
			{
				self::$buffer[self::$placeholder] = $content;
				self::placeHolderEnd();
				return;
			}

			// Start buffering page content
			ob_start();

			if (!empty($partial))
			{
				// Insert partial content into buffer
				require_once (App::$path . '/' . App::$partials[$partial]);
				
				// End placeholder, i.e. close buffer
				self::placeHolderEnd();
			}
		}
		
		public static function placeHolderEnd()
		{
			// Spit the buffer into $content
			if (empty(self::$buffer[self::$placeholder]))
			{
				self::$buffer[self::$placeholder] = ob_get_contents();
				self::$placeholder = '';

				// Clear down the buffer
				ob_end_clean();
			}
		}
		
		public static function placeHolderPartial($name, $partial)
		{
			self::placeHolder($name, null, $partial);
		}
		
		public static function contentPartial($partial, $shared = null)
		{
			// Inject content
			require_once (App::$path . '/' . App::$partials[$partial]);
		}
		
		public static function content($name, $return = false)
		{
			$content = (!empty(self::$buffer[$name]))? self::$buffer[$name]: '';
			
			if (!$return) echo $content;
			else return $content;
		}
		
		public static function render()
		{
			if (!empty(self::$placeholder)) self::placeHolderEnd();			
			
			// Pull template from cache, save disk IO
			$template_content = Cache::get('template-' . self::$template);

			// Include file if not cached
			if (!$template_content)
			{
				$template_file = App::$path . '/' . App::$templates[self::$template];

				// Attempt to cache
				Cache::set('template-' . self::$template, file_get_contents($template_file));
			
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