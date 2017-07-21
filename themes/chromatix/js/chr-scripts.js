/*

Author: David James
Agency: Chromatix Digital Agency 

Description: 
This file is used to control the user experience which don't affect responsive. 
chr-responsive.js is used to control responsive specific javascript code.

*/

jQuery(document).ready(function($){

	var chr_responsive_menu_breakpoint = 1200;
	var body = jQuery("body");

	// show content that is set to fade when it comes into the viewport, if it is already in the viewport on load
	jQuery(".fadeonview").addClass("off");
	setTimeout("fadeonview();",50); // run our fadeonview function to show anything that is required righ

	//Prevent clicking
	jQuery(".disable > a, a.disable, .disabled > a, a.disabled").click(function(event){
		if(jQuery(this).parent("li.disabled.megamenu").parents("html.oldie").length==0)
		{
			event.preventDefault();
		}
	});

	//Megamenu Lightbox
	if(!jQuery("html").hasClass("oldie")){ // don't apply to IE8
		jQuery("#header_menu ul.menu > li.menu-item-has-children.megamenu").on("mouseenter touchstart",function(event){
			if(typeof verge=="undefined" || verge.viewportW() >= chr_responsive_menu_breakpoint && !body.hasClass("product_form_open")){
				body.addClass("megamenu_open");
				body.addClass("megamenu_lightbox_activating megamenu_lightbox_is_active");
				jQuery("#megamenu_lightbox").stop().fadeIn(600,function(){
					body.removeClass("megamenu_lightbox_activating");
				});
			}
		}).on("mouseleave",function(event){
			if(typeof verge=="undefined" || verge.viewportW() >= chr_responsive_menu_breakpoint  && !body.hasClass("product_form_open")){
				body.removeClass("megamenu_open");
				body.addClass("megamenu_lightbox_deactivating");
				jQuery("#megamenu_lightbox").stop().fadeOut(400,function(){
					body.removeClass("megamenu_lightbox_deactivating megamenu_lightbox_is_active");
				});
			}
		});
	}

	if(jQuery(".home .front_page").length)
	{
		jQuery('.hero_slider').slick({
			dots: true,
			arrows: false,
			infinite: true,
			speed: 500,
			fade: true,
			autoplay: true,
			autoplaySpeed: 5000,
			pauseOnHover: false,
			cssEase: 'linear',
		});

		jQuery('.clients_wrap').slick({
			arrows: false,
			dots: false,
			slidesToShow: 5,
			slidesToScroll: 1,
			speed: 200,
			autoplaySpeed:4000,
			autoplay: true,
			responsive: [
		    {
		      breakpoint: 1200,
		      settings: {
		        slidesToShow: 4,
		        slidesToScroll: 4
		      }
		    },
		    {
		      breakpoint: 767,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    }
		   ]
		});
	}

	//Contact form fix
	jQuery("form.wpcf7-form").click(function(event){
		jQuery(this).removeClass("invalid").find(".wpcf7-response-output").fadeOut("fast");
	});

	persistent_header();
	scroll_to_anchor();
	// removeSwipey();

}); // document.ready


jQuery(window).scroll(function(event){
	
	persistent_header();
	fadeonview();
	// removeSwipey();
	
		
}); // window.scroll


// function removeSwipey(){
// 	if(jQuery(".swipey") && verge.viewportW() < 1200)
// 	{
// 		jQuery(".swipey").each(function(){
// 			var $this = jQuery(this);

// 			if(isInViewport($this))
// 			{
// 				setTimeout(function(){$this.fadeOut(400)}, 4000);
// 			}
// 		});
// 	}
// }


//Accepts dom element and returns if item is in viewport or not
function isInViewport(item){
	var _item = jQuery(item);
	var top_of_element = _item.offset().top;
	var bottom_of_element = _item.offset().top + _item.outerHeight();
	var bottom_of_screen = jQuery(window).scrollTop() + verge.viewportH();
	var top_of_screen = jQuery(window).scrollTop();

    if((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element))
    {
    	return true;
    }

    return false;
}

function scroll_to_anchor(){

	//Scroll to Hash values On Click
	var window_w = verge.viewportW();
	var scrollOffset = 120;
	if(window_w < 1279)
	{
		scrollOffset = 85;
	} 

	if(jQuery(".logged-in.admin-bar").length != 0)
	{
		scrollOffset = scrollOffset + 20;
	}

	jQuery('a[href*="#"]:not([href="#"])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = jQuery(this.hash);
	      target = target.length ? target : jQuery('[data-scroll=' + this.hash.slice(1) +']');
	      if (target.length) {
	        jQuery('html, body').animate({
	          scrollTop: target.offset().top - scrollOffset
	        }, 1000);
	        return false;
	      }
	    }
	 });

	//Scroll to URL
	var hash_val = window.location.hash;
	if(hash_val)
	{
		var elem = jQuery('[data-scroll=' + hash_val.slice(1) +']');
		if(elem.length != 0)
		{
			jQuery('html, body').animate({
	          scrollTop: elem.offset().top - scrollOffset
	        }, 1000);

		}
	}
}


function persistent_header(){
	var masthead = jQuery('#masthead');
 	var stickyHeaderTop = 0;
    var persitant_height = "132px";

	var condition = jQuery(window).scrollTop() > stickyHeaderTop;
    jQuery('body').toggleClass('header-scrolling', condition);
    masthead.toggleClass('scrolling', condition);
    jQuery('#stickyalias').toggleClass('display', condition);
}

function fadeonview(event){
	jQuery(".fadeonview.off").each(function(){
		if(jQuery(this).offset().top < (jQuery(window).scrollTop()+(jQuery(window).height()/1.2))){ jQuery(this).removeClass("off"); }
	});
}

/* browser detect */

var BrowserDetect={
	init:function(){
		this.browser=this.searchString(this.dataBrowser) || "Other";
		this.version=this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
	},searchString:function(data){
		for(var i=0;i<data.length;i++){
			var dataString=data[i].string;
			this.versionSearchString=data[i].subString;
			if(dataString.indexOf(data[i].subString)!=-1){
				return data[i].identity;
			}
		}
	},searchVersion:function(dataString){
		var index=dataString.indexOf(this.versionSearchString);
		if(index==-1){return;}
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},dataBrowser:[
			{string:navigator.userAgent,subString:"Edge",	identity: "Edge"}, // last tested with Edge 12.1024 (06/08/2015)
			{string:navigator.userAgent,subString:"Opera",	identity: "Opera"}, // --
			{string:navigator.userAgent,subString:"OPR",	identity: "Opera"}, // last tested with Opera 30 (06/08/2015)
			{string:navigator.userAgent,subString:"Chrome",	identity: "Chrome"}, // last tested with Chrome 44 (06/08/2015)
			{string:navigator.userAgent,subString:"MSIE",	identity: "Explorer"}, // last tested with Explorer 8, 9 & 10 (06/08/2015)
			{string:navigator.userAgent,subString:"Firefox",identity: "Firefox"}, // last tested with Firefox 37& 39 (06/08/2015)
			{string:navigator.userAgent,subString:"Version",identity: "Safari"}, // last tested with Safari 5.1 & 8 (06/08/2015)
			{string:navigator.userAgent,subString:"Safari",	identity: "Safari"}, // --
			{string:navigator.userAgent,subString:"rv",		identity: "Explorer"} // last tested with Explorer 11 (06/08/2015)
	]};
BrowserDetect.init();

// Adds useful class to the html tag for cross browser compatibility

jQuery("html")
	.addClass(BrowserDetect.browser)
	.addClass(BrowserDetect.browser+"-"+BrowserDetect.version);
Modernizr.addTest("idevice",function(){return (/iPhone|iPad|iPod/i.test(navigator.userAgent));});
Modernizr.addTest("android",function(){return (/Android/i.test(navigator.userAgent));});
