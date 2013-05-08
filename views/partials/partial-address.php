<?php
	namespace CRD\Core;

	$template = $this->template;
	$resources = $template->resources;

	// Resource example
	$address_1 = $resources->html('Contact Us', 'Address Line 1');
	$address_2 = $resources->html('Contact Us', 'Address Line 2');
	$town = $resources->html('Contact Us', 'Town');
	$county = $resources->html('Contact Us', 'County');
	$postcode = $resources->html('Contact Us', 'Postcode');
?>
			<div class="address">
<?php
	if (!empty($address_1)) :
?>
				<p><?= $address_1 ?></p>
<?php
	endif; if (!empty($address_2)) :
?>
				<p><?= $address_2 ?></p>
<?php
	endif; if (!empty($town)) :
?>
				<p><?= $town ?></p>
<?php
	endif; if (!empty($county)) :
?>
				<p><?= $county ?></p>
<?php
	endif; if (!empty($postcode)) :
?>
				<p><?= $postcode ?></p>
<?php
	endif;
?>
			</div>
