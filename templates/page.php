<?php
	namespace CRD\Core;

	$resources = $template->resources;
	$html = $template->html;
	$app = $template->app;
	$router = $template->router;

?><!doctype html>
<html lang="<?= $html->entities($resources->locale) ?>">
	<head>
		<meta charset="utf-8">
		<title><?= $html->entities(((!empty($template->title))? $template->title . ' — ' : '') . $app->name) ?></title>

		<!-- Handheld support -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSS includes -->
		<link rel="stylesheet" href="<?= $router->directory ?>/assets/css/engine.css?cache=<?= urlencode($app->version) ?>">
		
		<!-- Initialise advanced UI -->
		<script>document.documentElement.className = 'advanced';</script>
	</head>
	<body class="<?= $html->entities($template->page) ?>">
	
		<div id="container">
<?= $template->content('main') ?>
<?= $template->content('footer') ?>
		</div>
	</body>
</html>