<?php

// init stuff
global $post, $wp_query, $site_settings, $custom_tax_primary, $custom_post_primary, $custom_base_page;
get_header(); // inner page header is in here ('feature')

// write results count

	$count=$wp_query->found_posts;
	$prefix="";
	$suffix="result";
	if($count!=1) $suffix.="s"; // eg. 'results'
	if($count > $wp_query->query_vars["posts_per_page"]){ $prefix="About"; $count=round($count/10)*10; } // make result count fuzzy
	if($count > 100) $count=round($count/100)*100; // make it more fuzzy
	if($count > 1000) $count=round($count/1000)*1000; // make it more fuzzy
	$results_message=__($prefix)." ".$count." ".__($suffix);

?>
<article class="search_page full clearfix content_container">

	<div class="item special searchmeta">

		<?php
		if(have_posts()){
			?>
			
			<div class="search_term">
				<?php
				// show what we've searched for
				if($_GET["s"] === '')
				{
					echo "Showing All Posts";
				}
				else
				{
					echo __("For")." \"".trim(stripslashes($_GET["s"])," \"")."\"";
				}
				?>
			</div> <!-- .search_term -->
			
			<div class="results_message"><?php echo $results_message; ?></div>	
			
			<?php
		} // if have_posts
		?>
	</div> <!-- .item.special.searchmeta -->
	<?php
	if(have_posts())
	{
	?>
		<div class="search_results">
		<?php
			while(have_posts()){
				the_post();
				//get_template_part("content", "results");
			} // while have_posts()
			
			get_template_part("content","pagination"); // pagination if applicable
		?>
	</div>
	<?php  
	}
	else
	{
	?>
		
		<div class="item special noresults">
			<p><?php echo __("Sorry, no results could be found for your search. Please try another query."); ?></p>
		</div>
		
	<?php
	} // ifELSE have_posts 
	?>

</article>

<?php 
get_footer();
?>