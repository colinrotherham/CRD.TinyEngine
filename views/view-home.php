<?php
	$resources = $this->template->resources;

	// Start placeholder
	$this->template->placeHolder('main');
?>
			<h1><?= $resources->html('Home', 'Heading') ?></h1>
			<p><?= $resources->html('Home', 'Intro') ?></p>
			<p><?= $resources->html('Shared', 'Go to') ?> <a href="/contact/"><?= $resources->html('Contact Us', 'Heading') ?></a></p>
<?php
	// End placeholder
	$this->template->placeHolderEnd();
?>
