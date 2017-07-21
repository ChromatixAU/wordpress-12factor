<?php  
	//Template for category sections on homepage
	//and category template page

	if(have_rows('category_sections'))
	{
		while(have_rows('category_sections'))
		{
			the_row();
?>
			<section class="category fadeonview off">
				<?php	
					$heading = get_sub_field( 'heading' );
					if($heading)
					{
				?>
						<div class="title_wrap">
							<h3 class="category_title">
								<?php echo $heading; ?>
							</h3>
						</div>
				<?php
					}

					$products = get_sub_field( 'products' );
					if($products)
					{
				?>
						<div class="products_wrap clearfix">
							<?php  
								foreach ($products as $prod) 
								{
									$id = $prod->ID;
									$title = get_the_title($id);
									$thumb = get_field('product_thumbnail', $id);
									$link = get_permalink($id);

									if($title && $thumb && $link)
									{
							?>
										<a href="<?php echo $link; ?>" class="product" title="<?php echo $title; ?>">
											<div class="thumb_wrap">
												<?php  
													echo acf_image($thumb, 'large');
												?>
											</div>
											<div class="title_wrap">
												<div class="inner">
													<span class="title">
													<?php  
														echo $title;
													?>
													</span>
												</div>
											</div>
										</a>
							<?php
									}

								}
							?>
						</div>
				<?php
					}

					$btn_link = get_sub_field( 'link_full_range' );
					$btn_text = get_sub_field( 'text_full_range' );
					if($btn_link && $btn_text)
					{
				?>
						<div class="button_wrap">
							<a href="<?php echo $btn_link; ?>" class="jacloc-button" title="<?php echo $btn_text; ?>">
								<?php echo $btn_text; ?>
							</a>
						</div>
				<?php
					}
				?>
		</section>
<?php
		} //End while
	}
?>