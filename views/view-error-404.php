<?php
	$resources = $this->template->resources;

	// Start placeholder
	$this->template->placeHolder('main');
?>
			<h1><?= $resources->html('404', 'Heading') ?></h1>
			<p><?= $resources->html('404', 'Intro') ?></p>
			<p><?= $resources->html('Shared', 'Go to') ?> <a href="/"><?= $resources->html('Home', 'Heading') ?></a></p>
<?php
	// End placeholder
	$this->template->placeHolderEnd();
?>
