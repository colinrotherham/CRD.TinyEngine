<?php
	namespace CRD\Core;

	require_once ('../system/config/classes.php');

	$template = new Template($app, 'page', 'page-contact');
	$resources = $app->resources;

	// Start placeholder
	$template->placeHolder('main');
?>
			<h1><?= $resources->html('Contact Us', 'Heading') ?></h1>
<?php
	// Inject address partial
	$template->contentPartial('address');
?>
			<p><?= $resources->html('Shared', 'Go to') ?> <a href="/"><?= $resources->html('Home', 'Heading') ?></a></p>
<?php
	// End placeholder
	$template->placeHolderEnd();
?>
