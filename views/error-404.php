<?php
	$template = $view->template;
	$resources = $template->resources;
	$router = $view->app->router;

	$template->title = 'Sorry, page not found';

	// Start placeholder
	$template->placeHolder('main');
?>
			<h1><?= $resources->html('404', 'Heading') ?></h1>
			<p><?= $resources->html('404', 'Intro') ?></p>
			<p><?= $resources->html('Shared', 'Go to') ?> <a href="<?= $router->path('home') ?>"><?= $resources->html('Home', 'Heading') ?></a></p>
<?php
	// End placeholder
	$template->placeHolderEnd();
?>
