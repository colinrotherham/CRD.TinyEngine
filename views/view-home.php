<?php
	namespace CRD\Core;

	require_once ('../engine/start.php');

	$template = new Template($app, 'page', 'page-home');
	$resources = $app->resources;

	// Start placeholder
	$template->placeHolder('main');
?>
			<h1><?= $resources->html('Home', 'Heading') ?></h1>
			<p><?= $resources->html('Home', 'Intro') ?></p>
			<p><?= $resources->html('Shared', 'Go to') ?> <a href="/contact/"><?= $resources->html('Contact Us', 'Heading') ?></a></p>
<?php
	// End placeholder
	$template->placeHolderEnd();
?>
