<?php
// check if the flexible content field has rows of data
if( have_rows('subpage_content') )
{
     // loop through the rows of data
    while ( have_rows('subpage_content') )
    {
    	the_row();

		if(get_row_layout() == 'standard_content')
		{
			$content = get_sub_field('content');

			if($content)
			{
		?>
				<section class="content_section_wrap standard_content jacloc_sect ">

					<div class="content_container clearfix">
						<?php  
							echo $content;
						?>
					</div>
				</section>
		<?php
			}
		}
		elseif(get_row_layout() == 'quote_content')
		{
			$quote_content = get_sub_field('quote_content');

			if($quote_content)
			{
		?>
				<section class="content_section_wrap quote_content jacloc_sect ">

					<div class="content_container clearfix">
						<?php  
							echo $quote_content;
						?>
					</div>
				</section>
		<?php
			}
		}
		elseif(get_row_layout() == 'two_column')
		{
			$col_one = get_sub_field('column_one');
			$col_two = get_sub_field('column_two');

			if($col_one && $col_two)
			{
		?>
				<section class="content_section_wrap two_column jacloc_sect">
					<div class="content_container clearfix">
						<div class="col_one">
							<?php  
								echo $col_one;
							?>
						</div>
						<div class="col_two">
							<?php  
								echo $col_two;
							?>
						</div>
					</div>
				</section>				
		<?php
			}
		}
		elseif(get_row_layout() == 'content_with_left_image')
		{
			$left_image = get_sub_field('left_image');
			$right_content = get_sub_field('right_content');
			$img_link = get_sub_field('image_to_video_link');

			if($left_image && trim($left_image['url']) != '' && $right_content)
			{
		?>
				<section class="content_section_wrap content_left_image jacloc_sect">
					<div class="content_container clearfix">
						<div class="right_content">
							<?php  
								echo $right_content;
							?>
						</div>
						<?php
							//Image
							if($img_link)
							{
						?>
								<a href="<?php echo $img_link; ?>" rel="lightbox" data-lightbox-type="iframe" class="image_link">
						<?php
							}
						?>
								<div class="left_image">
									<?php  
										echo acf_image($left_image, '', 'image')
									?>
								</div>
						<?php
							if($img_link)
							{
						?>
								</a>
						<?php
							}
						?>
					</div>
				</section>				
		<?php
			}
		}
		elseif(get_row_layout() == 'content_with_right_image')
		{
			$right_image = get_sub_field('right_image');
			$left_content = get_sub_field('left_content');
			$img_link = get_sub_field('image_to_video_link');

			if($right_image && trim($right_image['url']) != '' && $left_content)
			{
		?>
				<section class="content_section_wrap content_right_image jacloc_sect">
					<div class="content_container clearfix">
						<div class="left_content">
							<?php  
								echo $left_content;
							?>
						</div>
						<?php
							//Image
							if($img_link)
							{
						?>
								<a href="<?php echo $img_link; ?>" rel="lightbox" data-lightbox-type="iframe" class="image_link">
						<?php
							}
						?>
							
								<div class="right_image">
									<?php  
										echo acf_image($right_image, '', 'image')
									?>
								</div>

						<?php
							if($img_link)
							{
						?>
								</a>
						<?php
							}
						?>
					</div>
				</section>				
		<?php
			}
		}
		elseif(get_row_layout() == 'content_full_image_section')
		{
			$center_content = get_sub_field('center_content');
			$full_image = get_sub_field('full_image');
			$full_image_replace = get_sub_field('full_image_replace');
			$img_link = get_sub_field( 'image_video_link' );

			if($full_image && trim($full_image['url']) != '' && $center_content)
			{
		?>
				<section class="content_section_wrap content_full_image jacloc_sect">
					<div class="content_container clearfix" style="padding-bottom: <?php echo ($full_image['height'] + 80) . "px"; ?>;">
						<div class="center_content">
							<?php  
								echo $center_content;
							?>
						</div>

					</div>
					<?php
						if($img_link)
						{
					?>
							<a href="<?php echo $img_link; ?>" rel="lightbox" data-lightbox-type="iframe" class="image_link">
					<?php
						}
					?>
							<div class="full_image_replace_wrap">
								<?php
									if($full_image_replace)
									{
										echo acf_image($full_image_replace, 'large', 'full_image_replace');
									}
								?>
							</div>
							<div class="full_image_wrap">
								<?php  
									echo acf_image($full_image, '', 'full_image');
								?>
							</div>
					<?php  
						if($img_link)
						{
					?>
							</a>
					<?php
						}
					?>
				</section>				
		<?php
			}	
		}
		elseif(get_row_layout() == 'three_column_feature_section')
		{
			$top_content = get_sub_field('top_content');

			if($top_content && have_rows('column_items'))
			{
		?>
				<section class="content_section_wrap three_col_feature jacloc_sect">
					<div class="content_container clearfix">
						<div class="top_content">
							<?php echo $top_content; ?>
						</div>
						<div class="column_wrap clearfix">
							<?php 
								$gallery_count = 0; 
								while(have_rows('column_items'))
								{
									the_row();
									$thumb = get_sub_field( 'thumbnail' );
									$title = get_sub_field( 'title' );
									$description = get_sub_field( 'description' );
									$lb_gallery = get_sub_field( 'lb_gallery' );

									if($thumb && $title && !empty($lb_gallery))
									{
							?>			
										<div class="col_item">
											<?php  
												$image_count = 0;
												$is_single = sizeof($lb_gallery) == 1 ? true : false;
												$rel = 'lightbox';
												
												//Fancyness to create a gallery for that particular
												if(!$is_single)
												{
													$rel = 'lightbox[gallery-'. $gallery_count . ']';
												}

												foreach ($lb_gallery as $image) 
												{
													if($image_count == 0 && $image && trim($image['url']) != '')
													{
											?>
														<a href="<?php echo $image['url']; ?>" title="<?php if(trim($image['caption']) != ''){ echo $image['caption']; } ?>" rel="<?php echo $rel; ?>" class="main_image">
															<?php  
																echo acf_background_image($thumb, 'medium', 'thumb_img')
															?>
															<h3 class="col_title">
																<?php echo $title; ?>
															</h3>
															<?php  
																if($description)
																{
															?>
																	<div class="description">
																		<?php echo $description; ?>
																	</div>
															<?php
																}


															?>
														</a>
											<?php
														$image_count++;
													}
													elseif($image && trim($image['url']) != '')
													{
											?>
														<a href="<?php echo $image['url']; ?>" title="<?php if(trim($image['caption']) != ''){ echo $image['caption']; } ?>" rel="<?php echo $rel; ?>" class="hidden_image">
														</a>
											<?php

													}
												}

											?>
										</div>
							<?php
										//Increment gallery number
										$gallery_count++;
									}
									elseif($thumb && $title)
									{
							?>
										<div class="col_item">
											<?php  
												echo acf_background_image($thumb, 'medium', 'thumb_img')
											?>
											<h3 class="col_title">
												<?php echo $title; ?>
											</h3>
										</div>
							<?php
									}
								}
							?>
						</div>
					</div>
				</section>				
		<?php
			}	
		}
		elseif(get_row_layout() == 'bg_section')
		{
			$bg_image = get_sub_field( 'bg_image' );
			$fixed = get_sub_field( 'is_fixed' );

			if($bg_image && trim($bg_image['url']) != '')
			{

		?>
				<section class="content_section_wrap bg_section jacloc_sect <?php if($fixed) echo 'fixed'; ?>">
					<?php  
						echo acf_background_image($bg_image, '', 'background');
					?>
				</section>				
		<?php
			}
		}
		elseif(get_row_layout() == 'content_feature_section')
		{
			$desktop_bg = get_sub_field( 'desktop_background' );
			$respo_bg = get_sub_field( 'respo_background' );
			$content = get_sub_field( 'featured_content' );
			$align_option = get_sub_field( 'content_alignment' );

			if($content && $desktop_bg && trim($desktop_bg['url']) != '')
			{

		?>
				<section class="content_section_wrap content_feature_section jacloc_sect">
					<?php  
						echo acf_background_image($desktop_bg, '', 'desktop_bg');
					
						if($respo_bg && trim($respo_bg['url']) != '')
						{
							echo acf_background_image($respo_bg, '', 'respo_bg');
						}
					?>
					<div class="content_container clearfix">
						<div class="content_table clearix <?php if($align_option == 'left') echo 'left_align'; ?>">
							<div class="content">
								<?php  
									echo $content;
								?>
							</div>
						</div>
					</div>
				</section>				
		<?php
			}
		}
	} //end while layouts
}
?>