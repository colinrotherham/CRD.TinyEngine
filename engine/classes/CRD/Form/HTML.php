<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Form;

	class HTML extends \CRD\Core\HTML
	{
		public $model = array();
		public $fields = array();
		public $errors = array();

		public function __construct(Validator &$validator)
		{
			$this->model = &$validator->model;
			$this->fields = &$validator->fields;
			$this->errors = &$validator->errors;
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

		public function selectOptionsLoop($list, &$default, &$markup)
		{
			// Loop options
			foreach ($list as $value => $label)
			{
				$value = $this->entities($value);

				// Loop options group
				if (is_array($label))
				{
					// Start group
					$markup .= "<optgroup label=\"$value\">\n";

					$this->selectOptionsLoop($label, $default, $markup);

					// End group
					$markup .= "</optgroup>\n";
				}

				else
				{
					$attributes = '';

					if (!empty($default) && $value == $default)
					{
						$attributes .= ' selected="selected"';
						$default = null;
					}

					$label = $this->entities($label);
					$markup .= "<option value=\"{$value}\"{$attributes}>{$label}</option>\n";
				}
			}
		}

		public function selectOptions($name, $list, $default = null)
		{
			$markup = '';
			$default = (!empty($this->fields[$name]))? $this->fields[$name] : $default;

			// Loop options
			$this->selectOptionsLoop($list, $default, $markup);

			return $markup;
		}

		public function attributes($name, $properties)
		{
			$fields = $this->fields;
			$attributes = '';

			if (empty($properties))
				$properties = array();

			$properties['class'] = $this->validate($name, !empty($properties['class'])? $properties['class'] : null);
			$properties['type'] = !empty($properties['type'])? $properties['type'] : 'text';

			// Password field, strip value
			if ($properties['type'] === 'password')
				$properties['value'] = null;

			// Textarea doesn't use a value/type attribute
			else if ($properties['type'] === 'textarea')
			{
				$properties['type'] = null;
				$properties['value'] = null;
			}

			// Radio buttons
			else if ($properties['type'] === 'radio' && isset($fields[$name]))
			{
				$properties['checked'] = null;

				if ($fields[$name] == $properties['value'])
					$properties['checked'] = 'checked';
			}

			// Checkboxes
			else if ($properties['type'] === 'checkbox' && !empty($fields[$name]))
				$properties['checked'] = 'checked';

			// Default, text-like
			else if (isset($fields[$name]))
				$properties['value'] = (!empty($fields[$name]))? $fields[$name] : null;

			// Add attributes
			foreach ($properties as $attribute => $value)
			{
				if ($value === null)
					continue;

				$value = $this->entities($value);
				$attributes .= " $attribute=\"$value\"";
			}

			return $attributes;
		}

		public function input($name, $properties = null)
		{
			$attributes = $this->attributes($name, array_merge(array('type' => 'text'), $properties));
			return "<input name=\"$name\"{$attributes}>\n";
		}

		public function textarea($name, $properties = array())
		{
			$attributes = $this->attributes($name, array_merge(array('type' => 'textarea'), $properties));
			$content = isset($this->fields[$name])? $this->fields[$name] : (!empty($properties['value'])? $properties['value'] : '');

			return "<textarea name=\"$name\"{$attributes}>{$content}</textarea>\n";
		}

		public function radio($name, $properties = null)
		{
			$attributes = $this->attributes($name, array_merge(array('type' => 'radio'), $properties));
			return "<input name=\"$name\"{$attributes}>\n";
		}

		public function checkbox($name, $properties = null)
		{
			$attributes = $this->attributes($name, array_merge(array('type' => 'checkbox'), $properties));
			return "<input name=\"$name\"{$attributes}>\n";
		}

		public function select($name, $options, $value = null, $properties = null)
		{
			$attributes = $this->attributes($name, $properties);

			$markup = "<select name=\"$name\"{$attributes}>\n";
			$markup .= $this->selectOptions($name, $options, $value);
			$markup .= "</select>";

			return $markup;
		}
	}
?>