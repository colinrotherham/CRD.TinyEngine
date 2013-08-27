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

			// Default character set
			if ($success) $this->connection->set_charset('utf8');

			return $success;
		}

		public function escape($string)
		{
			return $this->connection->escape_string($string);
		}

		public function query($query, $options = array())
		{
			if (!is_object($this->connection))
				throw new \Exception('Database connection: Failed');

			$types = '';
			$params = array();

			// Reset results
			$this->result = array();

			// Build query param types/values
			if (!empty($options))
			{
				foreach ($options as $i => $value)
				{
					$types .= $value[0];
					$params[] = &$options[$i][1];
				}
			}

			// Prepare query
			$statement = $this->connection->prepare($query);
			return $this->prepare($statement, $types, $params);
		}

		private function prepare($statement, $types, $params)
		{
			// Prepare statement
			if (!$statement)
				throw new \Exception('Database prepared statement: Failed');

			// Bind params and run query
			if (!empty($params))
			{
				// Add types to params, bind
				array_unshift($params, $types);
				call_user_func_array(array($statement, 'bind_param'), $params);
			}

			// Run query
			return $this->execute($statement);
		}

		private function execute($statement)
		{
			$row = array();

			// Run query
			$statement->execute();
			$statement->store_result();

			// Any rows?
			if ($statement->num_rows)
			{
				// Extract result columns
				$meta = $statement->result_metadata();

				// Loop columns, create column placeholders
				while ($field = $meta->fetch_field())
					$columns[] = &$row[$field->name];

				// Bind result columns
				call_user_func_array(array($statement, 'bind_result'), $columns);

				// Grab results
				while ($statement->fetch())
				{
					if (!$this->result)
						$this->result = array();

					// Don't assign by reference
					$this->result[] = unserialize(serialize($row));
				}
			}

			// Close query
			$statement->close();

			return $this->result;
		}
	}
?>
