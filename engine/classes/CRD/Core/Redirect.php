<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Redirect
	{
		private $permanent = 301;
		private $temporary = 302;
	
		public function to($url, $is_permanent = false)
		{
			// Which status code?
			$status = ($is_permanent)? $this->permanent : $this->temporary;
		
			// Perform redirect
			header('Location: ' . $url, true, $status);
			exit;
		}
	}
?>