<?php
	use \CRD\Core\Resource as Resource;

	$address_1 = Resource::get('Contact Us', 'Address Line 1');
	$address_2 = Resource::get('Contact Us', 'Address Line 2');
	$town = Resource::get('Contact Us', 'Town');
	$county = Resource::get('Contact Us', 'County');
	$postcode = Resource::get('Contact Us', 'Postcode');
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
