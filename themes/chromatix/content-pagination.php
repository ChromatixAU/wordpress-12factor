<?php

// prints out pagination, and can be used multiple times per page - the instance will be included as a class (1-based)
// should be called inside `if have_posts` and outside `while have_posts`

// CHROMATIX TM - November 2014

global $chr_pagination;

// generate pagination if it hasn't already been done
if(!isset($chr_pagination) || !is_array($chr_pagination)){
	
	$chr_pagination=array("instance"=>0); // track how many times we print out the pagination links
	
	if(get_previous_posts_link() || get_next_posts_link()){
		
		$big=999999999; // need an unlikely integer, if you ever have this many pages you're in trouble!
		$chr_pagination["content"]=paginate_links(array(
			"base"=>str_replace($big,"%#%",esc_url(get_pagenum_link($big))),
			"format"=>"?paged=%#%",
			"total"=>$wp_query->max_num_pages,
			"current"=>max(1,get_query_var("paged")),
			"show_all"=>false,
			"end_size"=>1,
			"mid_size"=>3,
			"prev_next"=>true,
			"prev_text"=>"",
			"next_text"=>"",
			"type"=>"plain"
		));
	} // if get_previous_posts_link or get_next_posts_link
} // if chr_pagination is not set or is not an array

// echo out pagination links if it's now set (i.e. if they exist) - otherwise nothing will be echoed
if(isset($chr_pagination["content"])){
	echo "<div class=\"pagination pagination-".$chr_pagination["instance"]."\">";
	echo $chr_pagination["content"];
	echo "</div> <!-- .pagination -->";
}

?>