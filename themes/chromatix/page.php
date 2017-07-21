<?php

// General Page Template for Jacloc

// init stuff
get_header();
the_post();

?>

<article class="item page full">
	<section class="page_header">
		<div class="inner_header content_container clearfix">
			<h1 class="page_title fadeonview off">
				<?php 
					if($post->post_parent && strtolower(get_post($post->post_parent)->post_name) === 'projects'){
							echo get_the_title($post->post_parent); //For Projects only for child page titles

						}else{
							the_title();
						}
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