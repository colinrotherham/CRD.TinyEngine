<?php
	$resources = $this->template->resources;

	// Start placeholder
	$this->template->placeHolder('main');
?>
			<h1><?= $resources->html('Contact Us', 'Heading') ?></h1>
<?php
	// Inject address partial
	$this->template->contentPartial('partial-address');
?>
			<p><?= $resources->html('Shared', 'Go to') ?> <a href="/"><?= $resources->html('Home', 'Heading') ?></a></p>
<?php
	// End placeholder
	$this->template->placeHolderEnd();
?>
