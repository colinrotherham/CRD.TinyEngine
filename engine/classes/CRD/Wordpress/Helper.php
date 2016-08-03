<?php

/*
	Copyright (c) 2015 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Wordpress;

	class Helper
	{
		private $template;
		private $templateRoutes;

		// Allow override of Wordpress routes
		public function __construct($templateRoutes = null)
		{
			if (!empty($templateRoutes))
				$this->templateRoutes = $templateRoutes;
		}


	/*
		Template helper methods
		----------------------------------- */

		public function getTemplate()
		{
			if (empty($this->template))
			{
				$override = $this->getTemplateRouteOverride();
				$pageId = $this->getPageId();
				$pageType = false;

				// Fetch override template file path
				if (!empty($override))
					$template = $override->template;

				// Fetch regular template file path
				else if (!empty($pageId))
				{
					// Get custom type
					if (get_post_type($pageId))
						$pageType = get_post_type($pageId);

					// Use custom type as slug
					if (!empty($pageType) && $pageType !== 'page')
						$template = get_post_type($pageId);

					// Use template name
					else {

						// Unless 404
						if (is_404())
							$template = '404';

						else $template = get_page_template_slug($pageId);
					}
				}

				// Template name, default to index
				$this->template = !empty($template)?
					basename($template, '.php') : 'index';
			}

			return $this->template;
		}

		public function getTemplateRoutes()
		{
			return $this->templateRoutes;
		}

		public function getTemplateRouteOverride()
		{
			global $wp;

			// Query parameters etc
			$params = $wp->query_vars;
			$overrides = $this->templateRoutes;

			// Default to no override
			$override = false;

			// Check for overrides
			if (!empty($overrides))
			{
				// Check for regex match on route
				foreach ($overrides as $category => $routes)
				{
					foreach ($routes as $name => $route)
					{
						// Pick match
						if (!empty($route->regex) && !!preg_match($route->regex, $_SERVER['REQUEST_URI']))
							$override = $overrides[$category][$name];
					}
				}

				// Check if category/name provided
				if (empty($override) && !empty($params['category_name']) || !empty($params['post_type']))
				{
					$category = null;

					// Is this category a post type?
					if (!empty($params['post_type']))
					{
						$typeData = get_post_type_object($params['post_type']);

						// Use post type as-is or use its rewrite?
						$category = !empty($typeData) && !empty($typeData->rewrite['slug'])?
							$typeData->rewrite['slug'] : $params['post_type'];
					}

					// Use category name
					else $category = $params['category_name'];

					// Matching category
					if (array_key_exists($category, $overrides))
					{
						// Use asterisk when no name provided
						$name = !empty($params['name'])?
							$params['name'] : '*';

						// In the override list?
						if (array_key_exists($name, $overrides[$category]))
							$override = $overrides[$category][$name];
					}
				}
			}

			return $override;
		}

		public function getPageTitle()
		{
			$override = $this->getTemplateRouteOverride();

			// Default Wordpress title, override if empty
			$name = !empty($override)? $override->title : wp_title('|', false, 'right');
			$description = get_bloginfo('description');

			// No title?
			if (empty($name))
				$name = get_bloginfo('name');

			// Add optional description
			$title = !empty($description)?
				"{$name} | {$description}" : "{$name}";

			// Clean up after Wordpress
			$title = rtrim($title, ' | ');
			$title = str_replace('|  | ', '| ', $title);
			$title = str_replace("{$name} | {$name},", "{$name},", $title);

			return $title;
		}

		public function getPageId()
		{
			global $post;

			if (empty($this->pageId))
			{
				$this->pageId = !empty($post)?
					$post->ID : url_to_postid($_SERVER['REQUEST_URI']);

				// No page ID
				if (empty($this->pageId))
				{
					$override = $this->getTemplateRouteOverride();

					// If no page ID, default to home
					if (empty($override))
						$this->pageId = get_option('page_on_front');
				}
			}

			return $this->pageId;
		}
	}
