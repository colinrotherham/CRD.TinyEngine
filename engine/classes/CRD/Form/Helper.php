<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Form;

	class Helper
	{
		public $type;
		public $callback;
		public $validator;
		public $helper;

		public function __construct($type, $model, $callback)
		{
			// Set properties
			$this->type = $type;
			$this->callback = $callback;

			// Create validator/helper objects
			$this->validator = new Validator($model);
			$this->helper = new HTML($this->validator);

			// Validate?
			if ($this->isPosted())
			{
				$this->validator->validate();

				// Check status and run callback
				if ($this->isSuccess())
					$callback($this);
			}
		}

		public function toEmail($to, $from, $subject, $message = '')
		{
			$fields = array();

			// Pad if message provided
			if (!empty($message))
				$message .= "\n\n";

			// Build message
			foreach ($this->validator->fields as $field => $value)
			{
				$field = $this->validator->model->$field;
				$message .= $field->name . ': ' . trim($value) . "\n";
			}

			// Send email
			mail($to, $subject, $message, "From: <{$from}>");
		}

		public function isPosted()
		{
			$isPosted = false;

			// Check for POST and form matches
			if (!empty($_POST['type']))
				$isPosted = $_POST['type'] === $this->type;

			// Check for posted type
			return $isPosted;
		}

		public function isSuccess()
		{
			$isSuccess = false;

			// Check form is submitted
			if ($this->isPosted())
				$isSuccess = count((array) $this->getErrors()) === 0;

			// Check for posted type
			return $isSuccess;
		}

		public function getErrors()
		{
			return $this->validator->errors;
		}
	}