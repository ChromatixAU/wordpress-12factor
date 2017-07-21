<?php
	if( have_rows('tabular_content') )
	{
?>
		<div class="tabs_wrap clearfix">
			<div class="tabs_select"></div>
			<ul class="tabs_list">
			<?php 

				$first = true;

				//Create Tabs List
				while( have_rows('tabular_content') )
				{
					the_row();
					$title = get_sub_field('tab_title');
					$content = get_sub_field('tab_content');

					if($title && $content)
					{
						
			?>
						<li class="tab <?php if($first) echo 'active'; ?>" data-title="<?php echo sanitize_title($title); ?>">
							<span class="tab_text">
							<?php
								echo $title;
							?>
							</span>
						</li>
			<?php
						if($first)
						{
								$first = false;
						}

					}
				}
			?>
				</ul>
			<?php

				$first = true;
				


				//Create Tab Content Items
				while( have_rows('tabular_content') )
				{
					the_row();
					$title = get_sub_field('tab_title');
					$content = get_sub_field('tab_content');
					$image = get_sub_field( 'right_image' );

					if($title && $content)
					{
			?>
						<article class="tab_content_item clearfix <?php if($first) echo 'active'; if($image && trim($image['url']) != '') echo ' has-image'; ?>">
							<h3 class="mobile_header">
								<?php echo $title; ?>
							</h3>
							<div class="content">
								<?php
									echo $content;
								?>
							</div>
							<?php  
								if($image && trim($image['url']) != '')
								{
									echo acf_background_image($image, '', 'right-image');
								}
								
							?>
						</article>
			<?php
						if($first)
						{
								$first = false;
						}

					}
				}
			?>
			</div>
<?php
	} // end tabular content