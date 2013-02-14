<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Database
	{
		private $app;
		private $result = false;

		public $connection;

		public function __construct($app)
		{
			$this->app = $app;
		}

		public function query($query, $multiple = false)
		{
			if (is_object($this->connection))
			{
				$this->result = ($multiple)? $this->connection->multi_query($query) : $this->connection->query($query);
				
				if (!$this->result && $this->app->debug)
					echo $this->connection->error;
			}
			
			else if ($this->app->debug)
			{
				echo "\nFailed to connect\n\n";
			}
			
			return $this->result;
		}
		
		public function queryClose()
		{
			if (is_object($this->result))
			{
				$this->result->close();
			}
		}
		
		public function connect($credentials_alternative = null)
		{
			global $credentials;
			
			if (!empty($credentials_alternative)) $credentials = $credentials_alternative;
		
			// Bring up a database connection
			if (empty($this->connection)) $this->connection = new \mysqli
			(
				$this->app->credentials->host,
				$this->app->credentials->username,
				$this->app->credentials->password,
				$this->app->credentials->database
			);
			
			// Any errors?
			$success = (!$this->connection->connect_error)? true : false;
			
			if ($success)
			{
				$this->connection->set_charset('utf8');
			}
			
			return $success;
		}
		
		public function escape($string)
		{
			return $this->connection->escape_string($string);
		}
	}
?>