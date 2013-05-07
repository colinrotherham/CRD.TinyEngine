<?php
	$template = $view->template;
	$resources = $template->resources;

	$template->title = 'Contact us';

	// Start placeholder
	$template->placeHolder('main');
?>
			<h1><?= $resources->html('Contact Us', 'Heading') ?></h1>
<?php
	// Inject address partial
	$template->contentPartial('partial-address');
?>
			<p><?= $resources->html('Shared', 'Go to') ?> <a href="/"><?= $resources->html('Home', 'Heading') ?></a></p>
<?php
	// End placeholder
	$template->placeHolderEnd();
?>
