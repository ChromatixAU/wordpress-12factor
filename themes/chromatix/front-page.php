
<?php

// init stuff

get_header();

?>
<article class="front_page">
	<section class="hero_section">
		<?php  
			if(have_rows( 'hero_slider'))
			{
		?>
				<div class="hero_slider">
					<?php  
						while(have_rows('hero_slider'))
						{
							the_row();
							$main_image = get_sub_field( 'main_image' );
							$respo_image = get_sub_field( 'respo_main_image' );
							$bg_image = get_sub_field( 'bg_image' );
							$content = get_sub_field( 'slide_content' );

							if($main_image && $respo_image && $bg_image && $content)
							{
					?>
								<div class="hero_slide">
									<div class="slide_content content_container clearfix">
										<div class="content_wrap clearfix">
											<div class="inner_wrap">
												<?php  
													echo $content;
												?>
											</div>
										</div>
										<?php  
											echo acf_background_image($main_image, '', 'main_image');

											echo acf_background_image($respo_image, '', 'respo_main_image');

											echo acf_background_image($bg_image, '', 'bg_image');
										?>
									</div>
								</div>
					<?php
							}
						}
					?>					
				</div>
		<?php
			}

		?>
	</section>
	<section class="first_section jacloc_sect">
		<div class="first_content content_container clearfix">
			<?php  
				$initial_content = get_field( 'initial_content' );

				if($initial_content)
				{
			?>
					<div class="initial_content">
						<?php echo $initial_content; ?>
					</div>
			<?php
				}

				$left_content = get_field( 'left_content' );
				$right_content = get_field( 'right_content' );

				if($left_content)
				{
			?>
					<div class="left_content fadeonview off">
						<?php echo $left_content; ?>
					</div>
			<?php
				}
			
				if($right_content)
				{
			?>
					<div class="right_content fadeonview off">
						<?php echo $right_content; ?>
					</div>
			<?php
				}
			?>
		</div>
	</section>
	<section class="categories_section jacloc_sect">
		<div class="categories_content content_container clearfix">
			<?php

				$featured_heading = get_field( 'featured_products_heading' );
				if($featured_heading)
				{
			?>
					<h2 class="featured_heading">
						<?php echo $featured_heading; ?>
					</h2>
			<?php
				}

				get_template_part('content', 'categories');
			?>
		</div>
	</section>
	<section class="clients_section jacloc_sect">
		<?php
			$clients_heading = get_field( 'clients_heading' );

			if($clients_heading && have_rows('clients'))
			{
		?>
				<div class="clients_content content_container clearfix">
					<h2 class="clients_heading">
						<?php echo $clients_heading; ?>
					</h2>
					<div class="clients_wrap">
						<?php  
							while(have_rows('clients'))
							{
								the_row();
								$image = get_sub_field( 'image' );
								$link = get_sub_field( 'link' );

								if($image && trim($image['url']) != '')
								{
						?>
									<div class="client_item">
						<?php
										if($link)
										{
							?>
											<a href="<?php echo $link; ?>" target="_blank" class="link">
							<?php
										}

											//Client logo here
											echo acf_background_image($image, 'medium', 'client_image');

										if($link)
										{
							?>
											</a>
							<?php
										}
						?>
									</div>
						<?php
								}
							}
						?>
					</div>
					<div class="swipey"></div>
				</div>
		<?php
			}
		?>		
	</section>
</article>

<?php

get_footer();

?>