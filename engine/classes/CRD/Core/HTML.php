<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class HTML
	{
		private $app;

		public function __construct($template)
		{
			$this->template = $template;
		}

		public function entities($value)
		{
			return htmlentities($value, ENT_QUOTES, 'UTF-8');
		}
	}
?>