<?php
	$template = $view->template;
	$resources = $template->resources;

	$template->title = 'Welcome';

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
