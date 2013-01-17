<?php
	require_once ('../system/config/classes.php');

	use \CRD\Core\Template as Template;
	use \CRD\Core\Resource as Resource;

	// Apply template
	Template::create('page', 'page-contact');

	// Start placeholder
	Template::placeHolder('main');	
?>
			<h1><?= Resource::html('Contact Us', 'Heading') ?></h1>
<?php
	// Inject address partial
	Template::contentPartial('address');
?>
			<p><?= Resource::html('Shared', 'Go to') ?> <a href="/"><?= Resource::html('Home', 'Heading') ?></a></p>
<?php
	// End placeholder
	Template::placeHolderEnd();
?>
