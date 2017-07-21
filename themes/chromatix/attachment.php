<?php

// disable attachment page, and just go straight to attachment

	wp_redirect(wp_get_attachment_url(), 301);
	exit();

// The end!
