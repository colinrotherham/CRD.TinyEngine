Tiny Engine
===========

How does it work?
-----------------

Tiny engine is a very simple master/view/partial templating engine.
It also throws in a little bit of APC caching for high-speed and supports
language resource files for multi-lingual apps.

Configuring the engine
----------------------

It's over to you really, stick it into a new Apache site and see how it runs.

1. Page templates and partials are defined here:

	/system/config/config.php

2. Templates, views and partials are stored as follows:

	/templates/template-page.php
	/views/view-contact.php
	/views/view-home.php
	/views/partials/partial-address.php

3. Resources for different locales are stored as follows:

	/resources/en-GB.php
	/resources/en-US.php

4. Finally, to map a route's URL to a view simply add it the old-fashioned way:

	.htaccess