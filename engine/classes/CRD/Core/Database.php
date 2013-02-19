<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	class Database
	{
		private $credentials;
		private $result = false;

		public $connection;

		public function __construct($credentials)
		{
			$this->credentials = $credentials;
		}

		public function query($query, $multiple = false)
		{
			if (is_object($this->connection))
			{
				$this->result = ($multiple)? $this->connection->multi_query($query) : $this->connection->query($query);
			}
			
			else throw new \Exception('Failed to connect to database');
			
			return $this->result;
		}
		
		public function queryClose()
		{
			if (is_object($this->result))
			{
				$this->result->close();
			}
		}
		
		public function connect()
		{
			// Bring up a database connection
			if (empty($this->connection)) $this->connection = new \mysqli
			(
				$this->credentials->host,
				$this->credentials->username,
				$this->credentials->password,
				$this->credentials->database
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