<?php

/* ************************** MENU REGISTRATION ************************** */

if(function_exists("register_nav_menus")){
	register_nav_menus(array(
		"main_menu"=>"Main navigation menu",
		"footer_menu_1"=>"Footer Menu 1",
		"footer_menu_2"=>"Footer Menu 2",
		"footer_menu_3"=>"Footer Menu 3"
	));
}


/* ************************** MEGA MENU WALKER *************************** */

class chr_megamenu_elements extends Walker_Nav_Menu {

	/* ************** START WORDPRESS original start_lvl() & end_lvl() functions - version 3.9.1 *****************
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
	function end_el( &$output, $item, $depth = 0, $args = array() ){
		$output.="</li>\n";
	}
	******************************************* END WORDPRESS ORIGINAL **************************************** */
	
	private $current_item = null;

	// Displays start of a level. Eg '<ul>'
	function start_lvl( &$output, $depth = 0, $args = array() ) 
	{
		$indent = str_repeat("\t", $depth);
		
		if ($depth == 0) 
		{
					
			$item = $this->current_item;
			if ($item && $this->has_children($item) && in_array("megamenu", $item->classes))
			{				
			 	$heading = $item->title;

			 	$mobile_head = '<div class="mobile_head"><span class="wrap"><span class="prev"></span><span class="heading">' . $heading . '</span></span></div>';

				// output html
				$output .= '<div class="megamenu_container">';
				$output .= "\n$indent". $mobile_head;
				$output .= "<ul class=\"sub-menu\">\n";			
			} 
			else if($item && $this->has_children($item))
			{
				$heading = $item->title;

			 	$mobile_head = '<div class="mobile_head"><span class="wrap"><span class="prev"></span><span class="heading">' . $heading . '</span></span></div>';
			 	
				$output .= '<div class="dropdown_container">';
				$output .= "\n$indent". $mobile_head;
				$output .= "<ul class=\"sub-menu\">\n";		
			}
		}
		else if($depth == 1)
		{
			// what to do if not depth 0 i.e tertiary menu
			$output .= "<ul class=\"tertiary-menu\">\n"; 
		}
	}

	// Displays end of a level. Eg. '</ul>'
	function end_lvl( &$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		if ($depth == 0) 
		{
			$item = $this->current_item;
			if ( $item && $item->menu_item_parent != '') 
			{
				$output .= "$indent</ul>\n</div>";
			}
			else 
			{
				// no children
				$output .= "$indent</ul>\n";
			}			
		} 
		else 
		{
			// tertiary
			$output .= "$indent</ul>\n";
		}
	}



	// Displays start of an element. Eg. '<li>' 
	function start_el(&$output,$item,$depth=0,$args=array(),$id=0){
		$this->current_item = $item;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' "' : '';

		/**
		 * Filter the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		
		$icon = ''; //Icon is initially unset
		if ($depth == 0) 
		{	
			$postid = $item -> object_id;

		    $path = get_field("page_icon", $postid);
			$svg = '';

			if($path)
			{
				$svg = SVGee::get($path); 
			}

			//Icon is added at <a> tag not <li>
			if($svg)
			{
				$icon = "<span class='menu_icon menu_". sanitize_title_with_dashes($item->title). "'>". $svg ."</span>";
			}

		    //Home Icon
			if(in_array("homepage", $item->classes))
			{
				$path = get_field('home_icon', 'options');
				$svg = SVGee::get($path); 

				//Icon is added at <a> tag not <li>
				if($svg)
				{
					$icon = "<span class='menu_icon menu_". sanitize_title_with_dashes($item->title). "'>". $svg ."</span>";
				}
			}

			$output .= $indent . '<li' . $id . $class_names .'>';
		} 
		elseif ($depth == 1 || $depth == 2) 
		{

			// Post ID 
			$postid = $item -> object_id;
			
			$output .= $indent . '<li' . $id . $class_names .'>';

		}

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) 
		{
			if ( ! empty( $value ) ) 
			{
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}


		$item_output = $args->before;
		$item_output .= '<a'. $attributes . ' ><span class="wrap">' . $icon;
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		
		$item_output .= '</span></a>';
		
		
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}	

	public function has_children($item) {
		return in_array('menu-item-has-children', $item->classes);
	}
}
//==========================================================================================================
	// add classes to menu items
add_filter("nav_menu_css_class","chr_add_menu_item_classes",10,2);
if(!function_exists("chr_add_menu_item_classes")){
function chr_add_menu_item_classes($classes,$item){
	
	// add a class with the name of the taxonomy term, if the menu item is a taxonomy term
	if($item->type=="taxonomy"){
		$term=get_term($item->object_id,$item->object);
		$classes[]="menu-item-taxonomy-".$term->taxonomy;
		$classes[]="menu-item-term-".$term->slug;
	}
	
	// add a class with the title/name of the item
	$classes[]="menu-item-title-".sanitize_title_with_dashes($item->title);
	
	// add has-description & has-image classes
	if(in_array("menu-item-has-children",$item->classes)){
		// only apply these to menu items with sub menus, because that's all we have the capability to display them for
		if(trim($item->description)!=""){ $classes[]="has-description"; }
		//if(trim($item->thumbnail_id)!=""){ $classes[]="has-image"; } // applies only to Menu Image plugin, needs to be rewritten for inbuilt menu images
	}
	
	return $classes;
}
}

//Submenu Limiting
add_filter("wp_nav_menu_objects","chr_submenu_limit",10,2);
if(!function_exists("chr_submenu_limit")){
function chr_submenu_limit($items,$args){
	if(empty($args->submenu)) return $items;
	$filtered=wp_filter_object_list($items,array("ID"=>$args->submenu),"and","ID");
	$parent_id=array_pop($filtered);
	$children=submenu_get_children_ids($parent_id,$items);
	if(isset($args->submenuheader) && $args->submenuheader){
		foreach($items as $key=>$item){ if((!in_array($item->ID,$children)) && ($item->ID!=$parent_id)) unset($items[$key]); }
	}else{
		foreach($items as $key=>$item){ if(!in_array($item->ID,$children)) unset($items[$key]); }
	}
	return $items;
}
}

if(!function_exists("submenu_get_children_ids")){
function submenu_get_children_ids($id,$items){
	$ids=wp_filter_object_list($items,array("menu_item_parent"=>$id),"and","ID");
	foreach($ids as $id) $ids=array_merge($ids,submenu_get_children_ids($id,$items));
	return $ids;
}
}

// advanced function to automatically create the most relevant submenu - pages under the current menu item if applicable, otherwise pages alongside the current menu item, and if the menu would be showing the top level, then don't display at all
if(!function_exists("chr_submenu")){
function chr_submenu($args){
	global $wp_query;
	$args["echo"]=false; // force echoing of the menu to false, because we need to check the output first
	
	$check_count=1; // min no. of items we'll be checking for before displaying a submenu - usually 1 is all we need
	if(isset($args["submenuheader"]) && $args["submenuheader"]) $check_count=2; // but, if we have a submenu header, we need to check for 2, otherwise we'll always end up with a submenu because we'll have the header!
	
	// first, grab the queried object and get it's type and ID
	$obj=$wp_query->get_queried_object();
	if(isset($obj->ID)) $object_id=$obj->ID;
		elseif(isset($obj->term_id)) $object_id=$obj->term_id;
	if(isset($obj->post_type)) $object_type=$obj->post_type;
		elseif(isset($obj->taxonomy)) $object_type=$obj->taxonomy;
	// there may be additional variables to check for, this should cover the majority for now though
	
	// set up vars for querying menu items
	$submenu_query_args=array(
		"posts_per_page"=>-1, // query all objects, we don't want any limits
		"meta_query"=>array(
			array(
				"key"=>"_menu_item_object_id", // query by the object id that the menu item links to
				"value"=>$object_id
			),array(
				"key"=>"_menu_item_object", // also check that we have the right object type, because different types can share IDs
				"value"=>$object_type
			)
		)
	);
	
	// grab submenu data
	$locations=get_nav_menu_locations();
	if(isset($locations[$args["theme_location"]])){
		$submenu_objs=wp_get_nav_menu_items($locations[$args["theme_location"]],$submenu_query_args); // grab menu items matching our query
		if(isset($submenu_objs) && count($submenu_objs)>0){ // if this has more than one result, it means an object is included more than once in this menu - of course we can't really tell which one is the right one, so we just have to grab the first one we have and hope for the best. it's a good idea not to include an object more than once because of this reason.
			$args["submenu"]=$submenu_objs[0]->ID; // set our submenu argument to pass to wp_nav_menu
			$submenu_output=wp_nav_menu($args); // grab the submenu supposedly under our current object's menu item, passing through most of the arguments we received
			if(substr_count($submenu_output,"<li ")>=$check_count){ // check that the submenu has enough items before displaying it
				echo $submenu_output; // yay, we have a submenu! show it
			}elseif($submenu_objs[0]->menu_item_parent!=0){
				// there was no submenu, so we grab the parent menu instead (i.e. sibling rather than child items of the current item), providing it is not the top level menu (because there's no point displaying the top level as a "submenu")
				$args["submenu"]=$submenu_objs[0]->menu_item_parent;
				echo wp_nav_menu($args); // echo it out.. if there's nothing to show, nothing will come out
			}
		}
	}
	
}
}

?>
