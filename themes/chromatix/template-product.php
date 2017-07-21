<?php 

/* Template Name: Product Page */
/* This is the page template for the Product page, to show relevant ACF fields. */

// init stuff
get_header();
the_post();

$option = get_field( 'layout_option' );

?>
<article class="item product full">
	<section class="initial_content_wrap">
		<div class="initial_content content_container clearfix <?php if($option == 'centred') echo 'centred'; ?>">
			<?php  

				$has_image = has_post_thumbnail();
				if($has_image && $option == 'left')
				{
			?>
					<div class="left_product_image fadeonview off">
						<?php  
							the_post_thumbnail('full');
						?>
					</div>
			<?php
				}
			?>
			<div class="title_wrap <?php if(!$has_image) echo 'no_image'; if($option == 'centred') echo 'centred_title_wrap'; ?>">
				<div class="inner_wrap">
					<h1 class="title fadeonview off">
						<?php the_title(); ?>
					</h1>
					<?php  
						$subtitle = get_field( 'product_subtitle' );
						if($subtitle)
						{
					?>
							<h3 class="subtitle fadeonview off">
								<?php echo $subtitle; ?>
							</h3>
					<?php
						}
					?>
				</div>
			</div>
			<?php  
				$has_image = has_post_thumbnail();
				if($has_image && $option == 'centred')
				{
			?>
					<div class="centred_product_image fadeonview off">
						<?php  
							the_post_thumbnail('full');
						?>
					</div>
			<?php
				}
			?>
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