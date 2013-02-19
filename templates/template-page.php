<?php
	namespace CRD\Core;

	$resources = $this->resources;
	$html = $this->html;
	$app = $this->view->app;

?><!doctype html>
<html lang="<?= $html->entities($resources->locale) ?>">
	<head>
		<meta charset="utf-8">
		<title><?= $html->entities(((!empty($this->title))? $this->title . ' — ' : '') . $app->name) ?></title>

		<!-- Handheld support -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSS includes -->
		<link rel="stylesheet" href="/assets/css/engine.css?cache=<?= urlencode($app->version) ?>">
		
		<!-- Initialise advanced UI -->
		<script>document.documentElement.className = 'advanced';</script>
	</head>
	<body class="<?= $html->entities($this->name) ?>">
	
		<div id="container">
<?= $this->content('main') ?>
<?= $this->content('footer') ?>
		</div>
	</body>
</html>