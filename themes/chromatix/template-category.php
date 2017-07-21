<?php 

/* Template Name: Category Page */
/* This is the page template for the Category page, to show relevant ACF fields. */

// init stuff
get_header();
the_post();

?>
<article class="item category_page page full">
	<section class="page_header">
		<?php  
			$header_image = get_field( 'header_image' );
			if($header_image)
			{
				echo acf_background_image($header_image, '', 'header_image');
			}
		?>
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
	<section class="categories_content content_container clearfix">
		<div class="inner_wrap">
			<?php 
				get_template_part('content', 'categories');
			?>
		</div>
	</section>
</article> 

<?php
get_footer();
?>