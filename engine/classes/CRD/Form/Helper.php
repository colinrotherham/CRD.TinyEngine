<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Form;

	class Helper
	{
		public $model = array();
		public $fields = array();
		public $errors = array();

		public function __construct(Validator $validator)
		{
			$this->model = $validator->model;
			$this->fields = $validator->fields;
			$this->errors = $validator->errors;
		}

		public function email($to, $from, $subject)
		{
			$fields = array();
			$message = '';

			foreach ($this->fields as $field => $value)
			{
				$field = $this->model->$field;
				$message .= $field->name . ': ' . trim($value) . "\n";
			}

			// Send email
			mail($to, $subject, $message, "From: <{$from}>");
		}

		public function escape($value)
		{
			return htmlentities($value, ENT_QUOTES, 'UTF-8');
		}

		public function validate($name, $class = null)
		{
			if (!empty($this->errors->$name))
			{
				// Add a trailing space to the default class?
				if (!empty($class)) $class .= ' ';

				$class .= 'invalid';
			}

			return $class;
		}

		public function selectOptions($name, $list, $default = null)
		{
			function process($list, &$default, &$markup)
			{
				// Loop options
				foreach ($list as $value => $label)
				{
					// Loop options group
					if (is_array($label))
					{
						// Start group
						$markup .= "<optgroup label=\"$value\">\n";

						process($label, $default, $markup);

						// End group
						$markup .= "</optgroup>\n";
					}

					else
					{
						$attributes = '';

						if (!empty($default) && $value === $default)
						{
							$attributes .= ' selected="selected"';
							$default = null;
						}

						$markup .= "<option value=\"{$value}\"{$attributes}>{$label}</option>\n";
					}
				}
			}

			$markup = '';
			$default = (!empty($this->fields[$name]))? $this->fields[$name] : $default;

			// Loop options
			process($list, $default, $markup);

			return $markup;
		}

		public function attributes($name, $properties, $type = 'text')
		{
			$fields = $this->fields;
			$attributes = '';

			if (empty($properties))
				$properties = array();

			$properties['class'] = $this->validate($name, (!empty($properties['class']))? $properties['class'] : null);

			// Override value if it exists
			if ($type === 'text' && isset($fields[$name]))
				$properties['value'] = (!empty($fields[$name]))? $fields[$name] : null;

			// Textarea doesn't use a value attribute
			else if ($type === 'textarea')
				$properties['value'] = null;

			// Radio buttons
			else if ($type === 'radio' && isset($fields[$name]))
			{
				$properties['checked'] = null;

				if ($fields[$name] === $properties['value'])
					$properties['checked'] = 'checked';
			}

			// Checkboxes
			else if ($type === 'checkbox' && !empty($fields[$name]))
				$properties['checked'] = 'checked';

			// Add attributes
			foreach ($properties as $attribute => $value)
			{
				if ($value === null)
					continue;

				$value = $this->escape($value);
				$attributes .= " $attribute=\"$value\"";
			}

			return $attributes;
		}

		public function input($name, $properties = null)
		{
			$attributes = $this->attributes($name, $properties);
			return "<input name=\"$name\" type=\"text\"{$attributes} />\n";
		}

		public function password($name, $properties = null)
		{
			$attributes = $this->attributes($name, $properties, 'password');
			return "<input name=\"$name\" type=\"password\"{$attributes} />\n";
		}

		public function textarea($name, $properties = null)
		{
			$attributes = $this->attributes($name, $properties, 'textarea');
			$content = isset($this->fields[$name])? $this->fields[$name] : (!empty($properties['value'])? $properties['value'] : '');

			return "<textarea name=\"$name\"{$attributes}>{$content}</textarea>\n";
		}

		public function radio($name, $properties = null)
		{
			$attributes = $this->attributes($name, $properties, 'radio');
			return "<input name=\"$name\" type=\"radio\"{$attributes} />\n";
		}

		public function checkbox($name, $properties = null)
		{
			$attributes = $this->attributes($name, $properties, 'checkbox');
			return "<input name=\"$name\" type=\"checkbox\"{$attributes} />\n";
		}

		public function select($name, $options, $value = null, $properties = null)
		{
			$attributes = $this->attributes($name, $properties, 'select');

			$markup = "<select name=\"$name\"{$attributes} />\n";
			$markup .= $this->selectOptions($name, $options, $value);
			$markup .= "</select>";

			return $markup;
		}
	}
?>