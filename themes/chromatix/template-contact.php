<?php 

/* Template Name: Contact Page */
/* This is the page template for the Contact page, to show relevant ACF fields. */

// init stuff
get_header();
the_post();

?>
<article class="item contact_page page full">
	<section class="page_header">
		<div class="inner_header content_container clearfix">
			<h1 class="page_title fadeonview off">
				<?php 
					the_title();
				?>
			</h1>
		</div>
	</section>
	<section class="content_main flexible_main">
		<?php  
			//Get flexible content if there is any
			get_template_part('content', 'flexible');
		?>
	</section>
</article> 

<?php
get_footer();
?>