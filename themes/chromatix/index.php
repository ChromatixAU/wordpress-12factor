<?php
global $post;
get_header();

if(have_posts()){

	//get_template_part("content","pagination"); // pagination if applicable
	
	while(have_posts()){
		the_post();
			?>
			<div class="item full clearfix">
				<h1><?php wp_title(""); ?></h1>
				<?php the_content(); ?>
			</div> <!-- .item -->
			<?php
	} // while have_posts()
	
	//get_template_part("content","pagination"); // pagination if applicable
	
}/*elseif(isset($_GET["s"])){ // blank search
	?>
	
	<div class="item special nosearch">
		<h1>Search results</h1>
		<p>Sorry, no results could be found for your search. Please try again.</p>
	</div> <!-- .item -->
	
	<?php
}else{
	?>
	
	<div id="content" class="item special noitem">
		<h1>An error has occurred</h1>
		<p>Sorry! An error has occurred and what you were looking for could not be found.</p>
		<p>Please try using the menus to find what you are looking for.</p>
			
			<?php if(WP_DEBUG){ ?>
				<h4>DEBUG INFO</h4>
				<pre><?php print_r($wp_query); ?></pre>
			<?php } // if WP_DEBUG ?>
			
	</div> <!-- .item -->
	
	<?php
} // if have_posts() & elses*/
get_footer();