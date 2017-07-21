<?php 

$content_width = 1280;
$static = false;
	
?><!DOCTYPE html>
<!--[if IE 6]><html class="no-js oldie" id="ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js oldie" id="ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js oldie" id="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js" id="ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8) | !(IE 9)  ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo("charset"); ?>" />
		<meta name="format-detection" content="telephone=no"/>
		<title><?php wp_title("|",true,"right"); ?></title>
		<link rel="pingback" href="<?php bloginfo("pingback_url"); ?>" />
		<meta name="viewport" content="width=<?php echo ( !$static ? "device-width" : $content_width+40); ?>" />
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/favicons/apple-touch-icon.png?v=1.1">
		<link rel="icon" type="image/png" href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/favicons/favicon-32x32.png?v=1.1" sizes="32x32">
		<link rel="icon" type="image/png" href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/favicons/favicon-16x16.png?v=1.1" sizes="16x16">
		<link rel="manifest" href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/favicons/manifest.json?v=1.1">
		<link rel="mask-icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/favicons/safari-pinned-tab.svg?v=1.1">
		<link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/favicons/favicon.ico?v=1.1">
		<meta name="msapplication-TileColor" content="#ffc40d">
		<meta name="msapplication-TileImage" content="<?php echo esc_url(get_template_directory_uri()); ?>/dist/favicons/mstile-144x144.png?v=1.1">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet">
		<meta name="theme-color" content="#4c6aaf">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<div class="ie9_browser_msg">
			You are currently using an outdated browser. For the best viewing experience, please upgrade your browser <a href="http://windows.microsoft.com/en-au/internet-explorer/download-ie">here</a>. 
		</div>
		<div id="megamenu_lightbox"></div>
			<header class="masthead" id="masthead">
				<div class="masthead-top clearfix">
					<div class="inner_masthead content_container clearfix <?php if(is_front_page()) echo 'fadeonview off'; ?>">
						<div class="inner-top">
							<div class="logo_container">
								<a href="<?php echo esc_url(home_url()); ?>" class="link">
									<img
										src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png"
										alt="<?php bloginfo("name"); ?>"
										title="<?php bloginfo("name"); ?>"
									/>
								</a>
							</div>
							<button id="mobile-toggle-wrap" class="hamburger hamburger--squeeze" type="button">
							  <span class="hamburger-box">
							    <span class="hamburger-label">Menu</span>
							    <span class="hamburger-inner"></span>
							  </span>
							</button>
						</div>
						<div class="masthead-bottom">
							<section id="header_menu" class="header_menu">
								<nav id="access" class="access">
									<?php
										wp_nav_menu(array(
											"theme_location"=>"main_menu",
											"depth"=>0, // 0 to display all levels; 1 to effectively disable megamenus & submenus; 2 for basic megamenus or simple submenus; 3+ for megamenus with submenus or submenus with multiple levels
											"link_before"=>"<span class='link'>",
											"link_after"=>"</span>",
											"container_class"=>"menu-main_menu-container",
											"walker"=>new chr_megamenu_elements() // set the container class so we know it's not going to change if the menu name changes
										));
									?>
								</nav><!-- .access -->
							</section> <!-- .header_menu -->
						</div>
					</div>
				</div>
			</header>
			<div class="chr_page">
				<div id="page" class="chr_content">
					<section class="page_content_wrapper">