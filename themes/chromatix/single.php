<?php

// init stuff

get_header();

the_post();

?>

<article class="item post full clearfix content_container">
	<section class="content_main">
		<article class="post_post ">
			<h3 class="assistive-text">Main article content</h3>
			<?php the_content(); ?>
		</article> 
	</section>
	<aside id="sidebar" class="sidebar content_side">
		<?php  
			//get_template_part('content', 'sidebar');
		?>
	</aside>
</article> 

<?php

get_footer();

?>