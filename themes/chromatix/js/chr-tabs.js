// Chromatix DJ 04/08/2016
// Chromatix Modularity - Tabular Content module

// Note: Rehash of tabs module for Iedex site
var tabletMax = 1500;
var phoneMax = 767;

jQuery(document).ready(function($){
	if(jQuery(".tabs-page").length)
	{
		tabs_init();

		responsive_tabs();
		setTimeout(responsive_tabs(), 100);

		jQuery(window).load(function(event){
			responsive_tabs();
		});

		jQuery(window).resize(function(event){
			responsive_tabs();
		});
	}
});

function tabs_init(){
	var z = 0; // initialise our tabular content ID variable
    jQuery(".tabs-page").each(function(){ // loop through each tabular content on the page

    	// set ID to refer to later on
        jQuery(this).find(".tabs_list").attr("data-cs", z);
        jQuery(this).find(".tabs_list .tab").attr("data-cs", z); 
        jQuery(this).find(".tabs_select").attr("data-cs", z); 
        jQuery(this).find(".tab_content_item").attr("data-cs", z);

        //increment z for next tabular content module
        z++;
    });

    var window_width = verge.viewportW();
    var desktop = window_width > tabletMax;
	var tablet = window_width <= tabletMax && window_width > phoneMax;
	var phone = window_width < phoneMax;

    var nav_items = jQuery('.tabs_list .tab');

	nav_items.click(function(event){
		var this_nav = jQuery(this);

		if(!this_nav.hasClass("active"))
	  	{
	  		open_tab(this_nav);
	  	}

		var	title = this_nav.attr("data-title");
		var	loc = "#" + title;

		// set new hash state while maintaining our scroll position, with browser-compat
		// HT: http://stackoverflow.com/a/5298684/1982136 & comments on http://stackoverflow.com/a/14690177/1982136
		if("pushState" in history)
		{
			// the new way, using pushState
			history.replaceState("", title, loc);
				
		}
		else
		{
			// the old way, for browser-compat
	
			scrollV = jQuery("html").scrollTop(); // grab the scroll position, because it will jump to the top
			scrollH = jQuery("html").scrollLeft();
			if(loc.indexOf("#") == -1){ window.location.hash = "tabs"; } // note: blank will set to null in IE9
			else{ window.location = loc; }
			jQuery("html").scrollTop(scrollV).scrollLeft(scrollH); // restore the original scroll position
		}


	});

	var select = jQuery(".tabs_select");
	select.on("click", function(event){
		var index = jQuery(this).attr('data-cs');
		var window_width = verge.viewportW();
		var tablet = window_width <= tabletMax && window_width > phoneMax;
	    var phone = window_width < phoneMax;

		if((tablet || phone))
		{
			var tabs_list = jQuery('.tabs_list[data-cs=' + index + ']');
			if (tabs_list.is(":visible")) 
			{
				tabs_list.slideUp(300);
				jQuery(this).toggleClass("opened");
			} 
			else 
			{
				tabs_list.slideDown(300);
				jQuery(this).toggleClass("opened");
			}
		}
	});

	//Check if window has hash to open certain tab
	if(window.location.hash)
	{
		var hash_tab = jQuery("[data-title='" + window.location.hash.replace("#", "") + "']");
		open_tab(hash_tab);

		// setTimeout(function(){
		// 	setTimeout(function(){
		// 		if(typeof chrmod_tabs_content_scrolloffset === 'undefined')
		// 		{
		// 			chrmod_tabs_content_scrolloffset = 100;
		// 		}
		// 		scroll_to_module(hash_tab, chrmod_tabs_content_scrolloffset);
		// 	}, 200);
		// }, 0);
		
	}

	
	open_tab(jQuery(".tabs_list .tab").first());
}

//Assumes jQuery object
function open_tab(opened_tab){
	var index = opened_tab.attr('data-cs');
	var clickedE = opened_tab.index('.tabs_list .tab[data-cs=' + index + ']');

	var tab_content_items = jQuery('.tab_content_item[data-cs=' + index + ']');
	var tabs = jQuery('.tabs_list .tab[data-cs=' + index + ']');

	//Remove classes (close all items)
	tabs.removeClass('active');
	tab_content_items.removeClass('active');

	//Add classes (open specific items)
	opened_tab.addClass("active");

	var currentContent = tab_content_items.eq(clickedE);
	currentContent.addClass("active");

	//On click event for tabs to interact with dropdowns on responsive
	var window_width = verge.viewportW();
	var tablet = window_width <= tabletMax && window_width > phoneMax;
    var phone = window_width < phoneMax;

	if((tablet || phone)){
		var clicked_tab_heading = opened_tab.text();
		var tabs_list = jQuery('.tabs_list[data-cs=' + index + ']');
		var dropdown = jQuery('.tabs_select[data-cs=' + index + ']');
		
		tabs_list.hide();
		dropdown.toggleClass("opened");
		dropdown.text(clicked_tab_heading);
	}
}


//Responsive tabs turned to drop down box 
function responsive_tabs()
{
    var window_width = verge.viewportW();
    var desktop = window_width > tabletMax;
	var tablet = window_width <= tabletMax && window_width > phoneMax;
	var phone = window_width < phoneMax;
    var all_tabs = jQuery(".tabs_list");
    var select = jQuery(".tabs_select");

    //Check if we have created select box or not
	if ( (tablet || phone)  && !select.hasClass("opened")) 
	{
		//Set up initial dropdown values
    	var active = jQuery(".tab.active")
    	jQuery.map(active, function(item, key){
    		var index = item.getAttribute('data-cs')
    		var dropdown = jQuery('.tabs_select[data-cs=' + index + ']');
    		dropdown.text(jQuery(item).text());
    	});
	}
	
	if(desktop)
	{
		all_tabs.css("display", "-webkit-flex");
		all_tabs.css("display", "-webkit-box");
		all_tabs.css("display", "-ms-flexbox");
		all_tabs.css("display", "flex");
	}
	else if((tablet || phone))
	{

		all_tabs.css("display", "block");
		select.removeClass("opened");
		all_tabs.hide();

	}

}