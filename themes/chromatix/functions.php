<?php
$assets_version_vendor="1.0.1"; // increment to immediately refresh all vendor (Chromatix) scripts & styles
$assets_version_plugin="1.0.1"; // increment to immediately refresh all plugin scripts & styles

/* **************************** TEMPLATE MODULE INCLUDES **************************** */

require("inc/menus.php"); // menu related functions
require("inc/customize.php"); // Wordpress customizer
require("inc/SVGee.php"); // SVG helper classv
require("inc/admin.php"); // admin php

/* **************************** DISABLE EXTRA HEADER TAGS ************************** */

add_action('init', 'theme_header_init');

function theme_header_init() {
    // remove extra links in header
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 2);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    remove_action('wp_head', 'print_emoji_detection_script', 7 );
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js'); 
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_print_styles', 'print_emoji_styles' );
    remove_action('template_redirect', 'rest_output_link_header', 11, 0 );

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off oEmbed auto discovery.
    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10); 
}


// function check_acf_plugin() {
//     include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
//     if (function_exists('is_plugin_active')) :
//         $acf_plugin_uri = 'advanced-custom-fields-pro/acf.php';
//         if (is_plugin_active($acf_plugin_uri)) :
//             include_once('inc/acf.php');
//         else:
//             add_action('admin_notices', 'acf_not_enabled_notice');            
//         endif;
//     endif;
// }

// add_action('init', 'check_acf_plugin');

// function acf_not_enabled_notice() {
// <div class="error notice">
//         <p><?php _e( 'This theme needs Advanced Custom Fields PRO to work, please enable plugin before continuing!', 'swinburne-solution-hub' ); </p> </div>
// }



/* **************************** SCRIPT & STYLE INCLUDES **************************** */


add_action("wp_enqueue_scripts","chr_enqueue_scripts");

if(!function_exists("chr_enqueue_scripts")){

	function chr_enqueue_scripts(){

		if(!is_admin()){

			global $assets_version_vendor, $assets_version_plugin;
			$td=get_template_directory_uri(); // keep our code a bit shorter!
			
			$chr_scripts=array();
			$chr_styles=array();


			$chr_scripts[]="smoothscroll";
			$chr_scripts[]="selectivizr";

			$chr_styles[]="styles"; // this generally shouldn't be changed

			foreach($chr_styles as $s){ wp_register_style("chr-".$s,"$td/css/$s.css",array(),$assets_version_vendor,"all"); }
			foreach($chr_scripts as $s){ wp_register_script($s,"$td/js/$s.js",array("jquery","modernizr"),$assets_version_vendor,true); }
			$chr_scripts[]="jquery";
			$chr_scripts[]="mousewheel";
			$chr_scripts[]="jscrollpane";
			$chr_scripts[]="verge";
			$chr_scripts[]="responsive";
			$chr_scripts[]="slick";

			//jQuery
			wp_deregister_script("jquery"); // so we can register our own, dev version
			wp_register_script("jquery","https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js",array(),"1.12.4",true);
			//wp_register_script("jquery",$td."/js/jquery.js",array(),$assets_version_plugin,true);

			//modernizr
			//wp_register_script("modernizr",$td."/js/compiled/custom-modernizr.js",array(),$assets_version_plugin,true); //Uncomment on production after compiled
			wp_register_script("modernizr",$td."/js/modernizr.js",array(),$assets_version_plugin,true); //Delete from JS folder before compilation

			wp_register_script("jscrollpane",$td."/js/jscrollpane.js",array("jquery","mousewheel"),$assets_version_plugin,true);
			wp_register_script("mousewheel",$td."/js/mousewheel.js",array("jquery","mousewheel-intent"),$assets_version_plugin,true);
			wp_register_script("mousewheel-intent",$td."/js/mousewheel-intent.js",array("jquery"),$assets_version_plugin,true);
			wp_register_script("verge",$td."/js/verge.min.js",array(),$assets_version_vendor,true);
			wp_register_script("slick",$td."/js/slick.min.js",array("jquery"),$assets_version_vendor,true);
			wp_register_script("responsive",$td."/js/chr-responsive.js",array(),$assets_version_vendor,true);
		

			wp_register_style("chr-styles",get_bloginfo("stylesheet_url"),$chr_styles,$assets_version_vendor,"all");
			wp_register_script("chr-scripts",$td."/js/chr-scripts.js",$chr_scripts,$assets_version_vendor,true);
			wp_enqueue_script("chr-scripts");
			wp_enqueue_style("chr-styles");

		}

	}

}

/* ******************************* ACF - OPTION PAGE ******************************* */


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

/* **************************** MEDIA - THUMBNAIL SIZES **************************** */

add_theme_support("post-thumbnails",array("post", "page"));

add_action("init","chr_image_sizes");
if(!function_exists("chr_image_sizes")){
	function chr_image_sizes(){
		add_image_size("frontpage_slideshow","1900","250",array("center","center"));
	}
}
add_filter("image_size_names_choose","chr_custom_sizes");
if(!function_exists("chr_custom_sizes")){
	function chr_custom_sizes($sizes){
		return array_merge($sizes,array(
			"frontpage_slideshow" => "Front page slideshow",
    	));
	}
}


/* **************************** MEDIA **************************** */

// allow special file type uploads in Wordpress media
add_filter("upload_mimes","chr_custom_upload_mimes");
if(!function_exists("chr_custom_upload_mimes")){
	function chr_custom_upload_mimes($existing_mimes=array()){
		$existing_mimes["svg"]="image/svg+xml"; // you may also want to make sure SVG media library thumbnails are fixed in chr-admin.js
		return $existing_mimes;
	}
}

// make thumbnail output use the background-image trick to give us better control over the image
add_filter("post_thumbnail_html","chr_post_thumbnail_html",10,5);
if(!function_exists("chr_post_thumbnail_html")){
function chr_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr){
	if(!is_admin()){
		$title=esc_attr(get_the_title($post_id));
		$classes=esc_attr("attachment-".$size." wp-post-image");
		$img=wp_get_attachment_image_src($post_thumbnail_id,$size);
		$image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true);
		$img[0]=esc_url($img[0]);

		if(!empty($image_alt))
		{
			$image_alt = $title;
		}
		array_walk($img,"esc_attr");
		$html='';
		//$html.='<a href="'.get_permalink($post_id).'" title="'.$title.'">';
		$html.='<img width="'.$img[1].'" height="'.$img[2].'" src="'.$img[0].'" style="background-image: url(\''.$img[0].'\');" class="'.$classes.'" alt="'.$image_alt.'" title="'.$image_alt.'" />';
		//$html.='</a>';
	}
	return $html;
}
}

//Create an ACF image to a certain size and enable background trickery if necessary 
function acf_image($image, $size){
	$html = '';
	$url = $image['url'];

	if($url && trim($url) != '')
	{
		if($size && array_key_exists($size, $image['sizes']))
		{
			$width = $image['sizes'][$size . '-width'];
			$height = $image['sizes'][$size . '-height'];
			$url = $image['sizes'][$size];
		}
		else
		{
			$width = $image['width'];
			$height = $image['height'];
		}

		$title = $image['title'];

		if(isset($image['alt']))
		{
			$title = $image['alt'];
		}

		if($width && $height && $url && trim($url) != '')
		{
			$html = '<img width="'.$width .'" height="'.$height .'" src="'.$url.'" style="background-image: url(\''.$url.'\');" alt="'.$title.'" title="'.$title.'" />';
		}
	}

	return $html;
}

//Create an ACF image as a div with aria label to a certain size and enable background trickery if necessary 
function acf_background_image($image, $size, $class){
	$html = '';
	$url = $image['url'];

	if($url && trim($url) != '')
	{
		if($size && array_key_exists($size, $image['sizes']))
		{
			$url = $image['sizes'][$size];
		}

		$title = $image['title'];

		if(isset($image['alt']))
		{
			$title = $image['alt'];
		}

		if($url && trim($url) != '')
		{
			$html = '<div class="'. $class . '" style="background-image: url(\''.$url.'\');" aria-label="'.$title.'"></div>';
		}
	}

	return $html;
}


/* ************************************ TITLE TAG ************************************ */

// modify the title
// comply with $seplocation documentation at https://codex.wordpress.org/Function_Reference/wp_title#Parameters
// https://tommcfarlin.com/filter-wp-title/
add_filter("wp_title","chr_wp_title",10,3);
if(!function_exists("chr_wp_title")){
function chr_wp_title($title,$sep,$seplocation){
	global $page,$paged,$chr_wp_title_calls;
	if($sep!="") $sep=" ".$sep." "; // Wordpress seems to do this by default, so we better do it as well
	
	// return as is for feeds
	if(is_feed()) return $title;
	
	// apply to the first time this filter is called only (i.e. in the <title> tag only)
	if($chr_wp_title_calls<1){
	
		// add the site name to the title
		if($sep!="" && $seplocation=="right") $title.=get_bloginfo("name");
		elseif($sep!="") $title=get_bloginfo("name").$title;
		
		// add the site description for the front page
		$site_description=get_bloginfo("description","display");
		if($site_description && (is_home()||is_front_page()) && $sep!=""){
			if($seplocation=="right") $title.=$sep.$site_description;
			else $title=$site_description.$sep.$title;
		}
		
		// add a page number to the title tag
		if($paged>=2 || $page>=2 && $sep!=""){
			$pagedesc=sprintf("Page %s",max($paged,$page));
			if($seplocation=="right") $title.=$sep.$pagedesc;
			else $title=$pagedesc.$sep.$title;
		}
		
		// add debug notice so we remember we're in debug mode
		if(WP_DEBUG) $title="[DEBUG] ". $title;
		
		// remove the helper wrappers we've added (added in timplate 2.3); we don't need them in the <title> tag
		$title=str_replace(array("{%","{#","%}","#}"),"",$title);
		
	}
	
	// apply to every other time this filter is called (i.e. NOT in the <title> tag)
	if($chr_wp_title_calls>=1){
		
		if(is_search()) $title=__("Search Results");
		
		$title=str_replace("{%","<span class='part'>",$title);
		$title=str_replace("{#","<span class='sep'>",$title);
		$title=str_replace(array("%}","#}"),"</span>",$title);
		
	}

	$chr_wp_title_calls++;
	return $title;

}
}

// add helper wrappers to the title, which enables us to wrap parts and separators in the wp_title filter above - added in timplate 2.3
add_filter("wp_title_parts","chr_wp_title_parts",10,3);
if(!function_exists("chr_wp_title_parts")){
	function chr_wp_title_parts($parts){
		array_walk($parts,function(&$value){
			$value="{%".$value."%}";
		});
		return $parts;
	}
}

/* **************************** HELPER FUNCTIONS **************************** */
//Remove http from web address
if(!function_exists("chr_remove_http")){
	function chr_remove_http($url) {
		//Remove trailing slash
		if(substr($url, -1) == '/') 
		{
			$url = substr($url, 0, -1);
		}

	   $disallowed = array('http://', 'https://');
	   foreach($disallowed as $d) {
	      if(strpos($url, $d) === 0) {
	         return str_replace($d, '', $url);
	      }
	   }

	   return $url;
	}
}

//Add ... to long excerpts
if(!function_exists("the_excerpt_max_charlength")){
	function the_excerpt_max_charlength($charlength) {

    	$excerpt = strip_tags(get_the_excerpt());

        $charlength++;

        if ( mb_strlen( $excerpt ) > $charlength ) {
                $subex = mb_substr( $excerpt, 0, $charlength - 5 );
                $exwords = explode( ' ', $subex );
                $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
                if ( $excut < 0 ) {
                        echo mb_substr( $subex, 0, $excut );
                } else {
                        echo $subex;
                }
                echo '...';
        } else {
                echo $excerpt;
        }
	}
}

/* **************************** Blog Posts **************************** */
// Remove tags support from posts
function chr_unregister_tags() {
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'chr_unregister_tags');


/* **************************** TinyMCE **************************** */

// add additional styles to TinyMCE
// important when including fonts from Google Fonts or TypeKit
// be sure to replace commas with %2C within the URL, as the TinyMCE CSS URL list is comma delimited
$external_fonts = array("https://fonts.googleapis.com/css?family=Montserrat:300,400,700");

add_filter("mce_css", "chr_mce_css");

if(!function_exists("chr_mce_css")){
    function chr_mce_css($urls){
        global $external_fonts;
        if(!isset($external_fonts) || !is_array($external_fonts) || !count($external_fonts)){ return $urls; }
        if(!empty($urls)){ $urls .= ","; } // list is comma delimited, so add a comma if there's things already there
        $urls .= str_replace(",", "%2C", implode(",", $external_fonts));
        return $urls;
    }
}


add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );
/*
 * Modify TinyMCE editor to remove H1.
 */
function tiny_mce_remove_unused_formats($init) {
	// Add block format elements you want to show in dropdown
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Pre=pre';
	return $init;
}


/* **************************** DEVICE DETECTION **************************** */
/*
global $isiPad,$isiPhone,$isiPod,$isiDevice,$isMobile;
$isiPad=strpos($_SERVER["HTTP_USER_AGENT"],"iPad")!==false;
$isiPhone=strpos($_SERVER["HTTP_USER_AGENT"],"iPhone")!==false;
$isiPod=strpos($_SERVER["HTTP_USER_AGENT"],"iPod")!==false;
$isiDevice=($isiPad||$isiPhone||$isiPod);

// last updated 24/04/2015 from http://detectmobilebrowsers.com/
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) $isMobile=true; else $isMobile=false;

// add `|android|ipad|playbook|silk` to first regex to detect tablets as well
// ref: http://detectmobilebrowsers.com/about
*/