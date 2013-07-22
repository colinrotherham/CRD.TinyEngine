<?php
	$template = $view->template;
	$resources = $template->resources;
	$router = $view->app->router;

	$template->title = 'Welcome';

	// Start placeholder
	$template->placeHolder('main');
?>
			<h1><?= $resources->html('Home', 'Heading') ?></h1>
			<p><?= $resources->html('Home', 'Intro') ?></p>
			<p><?= $resources->html('Shared', 'Go to') ?> <a href="<?= $router->path('contact') ?>"><?= $resources->html('Contact Us', 'Heading') ?></a></p>
<?php
	// End placeholder
	$template->placeHolderEnd();
?>
