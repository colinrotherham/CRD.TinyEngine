<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class HTML
	{
		public static function entities($value)
		{
			return htmlentities($value, ENT_QUOTES, 'UTF-8');
		}

		public static function entities_decode($value)
		{
			return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		}
	}
?>