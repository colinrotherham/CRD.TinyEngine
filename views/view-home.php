<?php
	require_once ('../system/config/classes.php');

	use \CRD\Core\Template as Template;
	use \CRD\Core\Resource as Resource;

	// Apply template
	Template::create('page', 'page-home');

	// Start placeholder
	Template::placeHolder('main');
?>
			<h1><?= Resource::html('Home', 'Heading') ?></h1>
			<p><?= Resource::html('Home', 'Intro') ?></p>
			<p><?= Resource::html('Shared', 'Go to') ?> <a href="/contact/"><?= Resource::html('Contact Us', 'Heading') ?></a></p>
<?php
	// End placeholder
	Template::placeHolderEnd();
?>
