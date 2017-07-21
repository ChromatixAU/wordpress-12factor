<?php

/*
Admin area functions
CHROMATIX TM, MAY 2014
*/

/* ************************************** GENERIC *************************************** */

// add favicon URL link to admin area
add_action("admin_head","chr_admin_head");
if(!function_exists("chr_admin_head")){
	function chr_admin_head(){ echo '<link rel="icon" href="'.get_template_directory_uri().'/dist/favicons/favicon.ico?v=0.2" />'; }
}

// add Chromatix credit to Wordpress admin
add_filter("admin_footer_text","chr_admin_footer");
if(!function_exists("chr_admin_footer")){
function chr_admin_footer($text){
	return "<span id=\"footer-thankyou\">Thank you for creating with <a href=\"https://wordpress.org/\">WordPress</a>, powered by <a href=\"http://chromatix.com.au\" target=\"_blank\">Chromatix Digital Agency</a>.</span>";
}
}

// modifications to Wordpress login page

add_filter("login_headerurl","chr_login_url");
add_filter("login_headertitle","chr_login_title");
add_filter("login_message","chr_login_message");

if(!function_exists("chr_login_url")){ function chr_login_url($login_header_url){ return home_url(); } }
if(!function_exists("chr_login_title")){ function chr_login_title($chr_login_header_title){ return get_bloginfo("name"); } }

if(!function_exists("chr_login_message")){
	function chr_login_message($message){
		if(get_option("users_can_register"))
			return "<p class='message'>Welcome to Wordpress, powered by Chromatix. Please login below, or <a href='".wp_registration_url()."'>register</a> if you do not yet have an account.</p>";
		else
			return "<p class='message'>Welcome to Wordpress, powered by Chromatix. Please login below.</p>";
	}
}


// login styles

add_action("login_enqueue_scripts","chr_enqueue_scripts_login");
if(!function_exists("chr_enqueue_scripts_login")){
function chr_enqueue_scripts_login(){
	global $assets_version_vendor, $assets_version_plugin;
	$td=get_template_directory_uri();
	wp_register_style("chr-login-css",$td."/css/admin-login.css",array(),$assets_version_vendor,"all");
	wp_register_script("chr-login-js",$td."/js/chr-login.js",array("jquery"),$assets_version_vendor,true);
	wp_enqueue_style("chr-login-css");
	wp_enqueue_script("chr-login-js");
}
}

/* ************************************ ADMIN MENUS ************************************* */

// remove unneeded admin & menu bar links

	add_action("admin_bar_menu","chr_modify_admin_bar",999999); // run last, after everything possible has been added
	if(!function_exists("chr_modify_admin_bar")){
	function chr_modify_admin_bar($wp_admin_bar){
		$user=wp_get_current_user();
		$wp_admin_bar->remove_node("wp-logo");
		$wp_admin_bar->remove_node("comments");
		$wp_admin_bar->remove_node("new-link"); // new "links"
		$wp_admin_bar->remove_node("new-user"); // new "user"
		$wp_admin_bar->remove_node("themes"); 
		$wp_admin_bar->remove_node("customize"); 
		$wp_admin_bar->remove_node("new-post");
		if(in_array("contributor",$user->roles)){
			//$wp_admin_bar->remove_node("comments");
			//$wp_admin_bar->remove_node("new-media");
		}
		if(current_user_can("manage_options")){
			// add link to the full, advanced, options page
			//$wp_admin_bar->add_menu(array("id"=>"all-settings","title"=>"Advanced Options","href"=>admin_url("options.php")));
		}
	}
	}

	add_action("admin_menu","chr_modify_admin_menu",999999); // run last, after everything possible has been added
	if(!function_exists("chr_modify_admin_menu")){
	function chr_modify_admin_menu(){
		$user=wp_get_current_user();
		// echo "<pre>".print_r($GLOBALS["menu"],true)."</pre>"; // run to get menu slugs ([2] in each array)
		//add_menu_page($page_title,$menu_title,$capability,$menu_slug,$function,$icon_url,$position);
		//http://codex.wordpress.org/Function_Reference/add_menu_page
		if(in_array("contributor",$user->roles)){
			//remove_menu_page("upload.php"); // media editor (the 'View own posts and media library items only' plugin can hide everything if they do get there by themselves)
			//remove_menu_page("tools.php"); // tools
			//remove_menu_page("wpcf7"); // contact form 7
			//remove_menu_page("index.php"); // dashboard
		}
		
		remove_menu_page("edit.php"); // post editor
			// remove_submenu_page("edit.php","edit-tags.php?taxonomy=post_tag"); // post tags
			//remove_submenu_page("edit.php","edit-tags.php?taxonomy=category"); // post categories
		remove_menu_page("edit-comments.php"); // comments
		remove_menu_page("link-manager.php"); // "link" manager
		remove_submenu_page("themes.php","customize.php"); // theme customizer
		remove_submenu_page("themes.php","widgets.php"); // widgets
		//remove_menu_page("plugins.php"); // plugins
		remove_menu_page("icwp-wpsf"); // simple firewall plugin
		
		// theme customizer - since Wordpress 4.0 this is HT to http://stackoverflow.com/a/26873392
		remove_submenu_page("themes.php",add_query_arg("return",urlencode(wp_unslash($_SERVER["REQUEST_URI"])),"customize.php"));
	}
	}

/* *********************** CONTRIBUTOR ACCESS ADJUSTMENTS *********************** */

// allow contributors to upload files, for featured images
// http://simon.xn--schnbeck-p4a.dk/upload-insert-images-as-a-wordpress-contributor/
//if(current_user_can("contributor")&&!current_user_can("upload_files")) add_action("admin_init","chr_allow_contributor_uploads");
if(!function_exists("chr_allow_contributor_uploads")){
function chr_allow_contributor_uploads(){
	$contributor=get_role("contributor");
	//$contributor->add_cap("upload_files");
}
}

// force which metaboxes contributors can see by default - basically, hide anything we know about except for ACF, and postimagediv (and publishdiv of course!)
// http://wordpress.stackexchange.com/a/88990
//if(current_user_can("contributor")) add_filter("hidden_meta_boxes","chr_custom_hidden_meta_boxes");
if(!function_exists("chr_custom_hidden_meta_boxes")){
	function chr_custom_hidden_meta_boxes($hidden){
		return array(
			"addthis","video_thumbnail","categorydiv","tagsdiv-post_tag",
			"postexcerpt","trackbacksdiv","postcustom","commentstatusdiv",
			"slugdiv","amt-metadata-box"
		);
	}
}

/* ************************************* EDITING ************************************* */

// revert the change added in Wordpress 4.2 that hides content entry on the posts page when the content is blank (it was added because most themes don't use it)
// comment this out if you don't want to be able to edit content on that page! when entered, content it's natively printed out by timplate's default archive.php
// HT: http://robincornett.com/posts-page/
	
	add_action("edit_form_after_title","chr_posts_page_edit_form");
	if(!function_exists("chr_posts_page_edit_form")){
	function chr_posts_page_edit_form(){
		global $post, $post_type, $post_ID;
		if($post_ID==get_option("page_for_posts") && empty($post->post_content))
			add_post_type_support($post_type,"editor");
	}
	}

// add/remove options from the post edit columns, such as comments, categories, tags, post formats and post thumbnails

	//add_filter("manage_edit-post_columns","chr_modify_admin_post_columns");
	if(!function_exists("chr_modify_admin_post_columns")){
	function chr_modify_admin_post_columns($columns){
		unset($columns["comments"]); // remove comments column; they're not supported in this theme
		unset($columns["categories"]); // also not supported
		unset($columns["tags"]); // AND also not supported
		
		// slice in post formats & thumbnails (can't be sPliced in because we need to maintain the keys)
		$columns=
			array_slice($columns,0,1) // checkbox
			+ array("featured_image"=>"") // splice in a featured image column in 2nd place
			+ array_slice($columns,1,2) // title & author
			+ array("post_format"=>"Format") // splice in a format column in 5th place
			+ array_slice($columns,3); // everything that's left (usually, in this order: taxonomies; custom taxonomies with admin columns switched on; comments; date)
			
		return $columns;
	}
	}
	
	add_action("manage_posts_custom_column","chr_post_custom_columns",10,2);
	if(!function_exists("chr_post_custom_columns")){
	function chr_post_custom_columns($column_name,$post_id){
		switch($column_name){
			case "post_format":
				$format=get_post_format();
				if(false===$format) $format="standard";
				echo _x($format,"Post format");
			break;
			case "featured_image": the_post_thumbnail(array(50,50)); break;
		}
	}
	}

// remove metaboxes that we're not using

	//add_action("add_meta_boxes","chr_remove_metaboxes");
	if(!function_exists("chr_remove_metaboxes")){
	function chr_remove_metaboxes(){
		
		// comments & trackbacks
		remove_meta_box("commentsdiv","post","normal");
		remove_meta_box("commentstatusdiv","post","normal");
		remove_meta_box("commentsdiv","page","normal");
		remove_meta_box("commentstatusdiv","page","normal");
		remove_meta_box("trackbacksdiv","post","normal");
		
		// categories & tags
		remove_meta_box("categorydiv","post","side");
		remove_meta_box("tagsdiv-post_tag","post","side");
		
		// excerpts
		//remove_meta_box("postexcerpt","post","normal");
		
		// author
		//remove_meta_box("authordiv","post","normal");
		remove_meta_box("authordiv","page","normal");
		
		// add meta tags plugin
		remove_meta_box("amt-metadata-box","post","advanced");
		remove_meta_box("amt-metadata-box","page","advanced");
		
		// misc
		remove_meta_box("pageparentdiv","post","side");
		
	}
	}

// add featured image to category columns
//add_filter("manage_edit-category_columns","chr_category_edit_columns");
//add_action("manage_category_custom_column","chr_category_custom_columns",10,3);
if(!function_exists("chr_category_edit_columns")){
function chr_category_edit_columns($columns){
	$columns=array_merge(
		array_slice($columns,0,1),
		array("featured_image"=>""), // splice in a featured_image column in second place
		array_slice($columns,1)
	);
	return $columns;
} // function chrcpt_tax_edit_columns
}
if(!function_exists("chr_category_custom_columns")){
function chr_category_custom_columns($content,$column,$term_id){
	switch($column){
		case "featured_image":
			$content=get_field("additional_content","category_".$term_id)[0];
			$url=$content["featured_image"]["sizes"]["thumbnail"];
			if(trim($url)==""){
				// there's no featured image assigned directly to this taxonomy term, so let's grab the first featured image we can find that's assigned to a post with this term
				$postquery=new WP_Query();
				$postquery->query(array(
					"posts_per_page"=>1,
					"cat"=>$term_id,
					"post_type"=>"post",
					"post_status"=>"publish",
					"meta_key"=>"_thumbnail_id", // make sure we have a featured image on this post!
				));
				if($postquery->post_count>0){
					$img=wp_get_attachment_image_src(get_post_thumbnail_id($postquery->post->ID),"large");
					$url=$img[0];
				}
			}
			if(trim($url)=="") $url="http://placehold.it/50x50"; // still nothing, so we'll use a placeholder image
			?>
			<img src="<?php echo $url; ?>" width="50" height="50" />
			<?php
		break;
	} // switch column
} // function chrcpt_tax_custom_columns
}

// add body classes to tiny mce for per-page styling purposes
add_filter("tiny_mce_before_init","chr_tiny_mce_classes");
if(!function_exists("chr_tiny_mce_classes")){
function chr_tiny_mce_classes($init_array){
	global $post;
	$init_array["body_class"]="chr-content chr_content";
	if(is_a($post,"WP_Post"))
		$init_array["body_class"].=" post-".$post->ID." post-".$post->post_name." post-type-".$post->post_type;
	return $init_array;
}
}

// tinymce table classes - under con
/*
add_filter("tiny_mce_before_init","chr_tinymce_options");
if(!function_exists("chr_tinymce_options")){
function chr_tinymce_options($opt){
	//print_r($opt);
	$opt["table_class_list"]="[{title: 'None', value: ''},{title: 'Dog', value: 'dog'},{title: 'Cat', value: 'cat'}]";
	$opt["table_styles"]="Test1=test1;Test2=test2";
	//$opt["table_class_list"]="{title: 'None', value: ''}";
	//print_r($opt);
	return $opt;
}
}*/

/* ************************************* SETTINGS ************************************* */

// remove the posts per page setting from the admin
// this is useful if posts per page are overriden on the frontend (see query.php)
//add_action("admin_print_footer_scripts","chr_remove_posts_per_page");
if(!function_exists("chr_remove_posts_per_page")){ function chr_remove_posts_per_page(){ if(is_admin()) echo "<script>jQuery(\"#posts_per_page\").parent().parent().hide();</script>"; } }

/* ********************************* SCRIPTS & STYLES ********************************* */

// register admin theme
wp_admin_css_color("chromatix","Chromatix",get_template_directory_uri()."/css/admin-colors.css",
	array("#95B821","#ACC55B","#454545","#85A619") // ligeti theme
	//array("#","#","#","#") // NEW theme
	//array("#10803F","#005B27","#0B682E","#7DBAA7") // glenallen theme
	//array("#BD0B1B","#25282B","#D12030","#4C4141") // CAPS theme
	//array("#124489","#0063BE","#000001","#85A619") // smartcom theme
);

remove_action("admin_color_scheme_picker","admin_color_scheme_picker"); // remove ability to change colour schemes
//add_filter("get_user_option_admin_color","chr_force_admin_color"); // force our new admin theme - don't use this unless you also remove ability to change on the line above
if(!function_exists("chr_force_admin_color")){ function chr_force_admin_color($result){ return "chromatix"; } }

add_action("admin_enqueue_scripts","chr_enqueue_scripts_admin");
if(!function_exists("chr_enqueue_scripts_admin")){
function chr_enqueue_scripts_admin(){
	global $assets_version_vendor, $assets_version_plugin;
	// admin panel styling & scripting
	//p_register_script("chr-admin-js",get_template_directory_uri()."/js/chr-admin.js",array(),$assets_version_vendor,true);
	wp_register_style("chr-admin-css",get_template_directory_uri()."/css/admin-generic.css",array(),$assets_version_vendor,"all");
	//wp_enqueue_script("chr-admin-js");
	wp_enqueue_style("chr-admin-css");
	wp_enqueue_media(); // enqueue media scripts on every page, this is required if we want to manually use the media library on pages such as the menu page
}
}

add_action("admin_print_footer_scripts","chr_js_admin_footer");
// add renamed post formats to the footer so that links to post formats in admin posts panel still work correctly - for some reason they don't get picked up when you change the name of the post formats
if(!function_exists("chr_js_admin_footer")){
function chr_js_admin_footer(){
	//$post_formats=get_theme_support("post-formats");
	if(function_exists("chr_get_post_format_names")){
		echo "<script>var chr_post_format_names=new Array();";
		foreach(chr_get_post_format_names() as $original=>$new)
			echo "chr_post_format_names.push(new Array('".$original."','".$new[0]."','".$new[1]."'));";
		echo "</script>";
	}
}
}

/* ************************************** The end! ************************************** */

?>