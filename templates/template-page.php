<?php
	use \CRD\Core\App as App;
	use \CRD\Core\Template as Template;
	use \CRD\Core\Resource as Resource;

?><!doctype html>
<html lang="<?php echo Resource::$locale; ?>">
	<head>
		<meta charset="utf-8">
		<title><?= ((!empty(Template::$title))? Template::$title . ' — ' : '') . App::$name; ?></title>

		<!-- Handheld support -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSS includes -->
		<link rel="stylesheet" href="/assets/css/engine.css">
		
		<!-- Initialise advanced UI -->
		<script>document.documentElement.className = 'advanced';</script>
	</head>
	<body class="<?= Template::$name ?>">
	
		<div id="container">
<?= Template::content('main') ?>
<?= Template::content('footer') ?>
		</div>
	</body>
</html>