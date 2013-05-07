<?php
	$template = $this->template;
	$resources = $template->resources;

	$template->title = 'Sorry, page not found';

	// Start placeholder
	$template->placeHolder('main');
?>
			<h1><?= $resources->html('404', 'Heading') ?></h1>
			<p><?= $resources->html('404', 'Intro') ?></p>
			<p><?= $resources->html('Shared', 'Go to') ?> <a href="/"><?= $resources->html('Home', 'Heading') ?></a></p>
<?php
	// End placeholder
	$template->placeHolderEnd();
?>
