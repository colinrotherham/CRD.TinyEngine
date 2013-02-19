<?php
	namespace CRD\Core;

	$resources = $this->resources;

	// Resource example
	$address_1 = $resources->get('Contact Us', 'Address Line 1');
	$address_2 = $resources->get('Contact Us', 'Address Line 2');
	$town = $resources->get('Contact Us', 'Town');
	$county = $resources->get('Contact Us', 'County');
	$postcode = $resources->get('Contact Us', 'Postcode');
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
