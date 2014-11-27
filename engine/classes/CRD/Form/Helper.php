<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Form;

	class Helper
	{
		public $type;
		public $validator;
		public $helper;

		// Callbacks
		public $onPreSubmit; // Before validation
		public $onSubmit; // After validation (any)
		public $onSuccess; // After validation (successful only)

		public function __construct($type, $model, $onSuccess = null, $onSubmit = null, $onPreSubmit = null)
		{
			// Set properties
			$this->type = $type;
			$this->onSuccess = $onSuccess;
			$this->onSubmit = $onSubmit;
			$this->onPreSubmit = $onPreSubmit;

			// Create validator/helper objects
			$this->validator = new Validator($model);
			$this->helper = new HTML($this->validator);
		}

		public function validate()
		{
			// Validate?
			if ($this->isPosted())
			{
				$onSuccess = $this->onSuccess;
				$onSubmit = $this->onSubmit;
				$onPreSubmit = $this->onPreSubmit;

				// Run pre-submit callback before validation
				if (is_callable($onPreSubmit))
					$onPreSubmit($this);

				// Validate
				$this->validator->validate();

				// Run submit callback after validation
				if (is_callable($onSubmit))
					$onSubmit($this);

				// Check status and run callback
				if ($this->isSuccess() && is_callable($onSuccess))
					$onSuccess($this);
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

				// Array of values
				if (is_array($value)) foreach ($value as $part)
					$message .= $field->name . ': ' . trim($part) . "\n";

				// Single field
				else $message .= $field->name . ': ' . trim($value) . "\n";
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