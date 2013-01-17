<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class App
	{
		public static $name = '';
		public static $path = '';
		
		public static $templates = array();
		public static $partials = array();
		
		public static $cache_enabled = true;
		public static $cache_length = 3600;
	}