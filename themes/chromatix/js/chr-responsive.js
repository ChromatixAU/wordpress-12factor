/*

Author: David James
Agency: Chromatix Digital Agency 

Description: 
This file is used to control the responsive user experience animation. 

*/

jQuery(document).ready(function($){

	// ======= MOBILE MENU ======= // 
	function mobile_menu(){
		var window_w = verge.viewportW();
		var window_h = verge.viewportH();
		var body = jQuery("body");
		var hamburger = jQuery("#mobile-toggle-wrap")


		hamburger.on("click", function(){
			if(hamburger.hasClass("is-active"))
			{
				body.removeClass("mobile-menu-open");
				hamburger.removeClass("is-active");
				// jQuery(".masthead-bottom").height(0);
			}
			else
			{
				body.addClass("mobile-menu-open");
				hamburger.addClass("is-active");
				set_mobile_menuH();
			}
		});

		//Mobile Menu
		jQuery(".mobile_head .prev, .mobile_head .heading").on("click", function(){
			if(verge.viewportW() < 1200 && body.hasClass("mobile-menu-open") && body.hasClass("megamobile"))
			{
				setTimeout(function(){
					body.removeClass("megamobile"); //Remove before its added again
					jQuery(".disable.open").removeClass("open");

				},20);
			}
			
		});

		jQuery(".disable.menu-item-has-children").on("click", function(){
			if(verge.viewportW() < 1200 && body.hasClass("mobile-menu-open") && !body.hasClass("megamobile"))
			{
				body.addClass("megamobile");
				jQuery(this).addClass("open");
			}
			
		});

		jQuery("#megamenu_lightbox").on("click", function(){
			if(verge.viewportW() < 1200 && body.hasClass("mobile-menu-open"))
			{
				body.removeClass("mobile-menu-open");
				hamburger.removeClass("is-active");
			}
		});
	}

	function set_mobile_menuH(){
		var window_w = verge.viewportW();
		var window_h = verge.viewportH();
		var body = jQuery("body");
		var hamburger = jQuery("#mobile-toggle-wrap")
		var topMastH = jQuery(".inner-top").outerHeight();

		//Resize if menu is open
		jQuery("#header_menu").height(window_h - topMastH);

		if(hamburger.hasClass("is-active"))
		{
			jQuery(".masthead-bottom").height(window_h - topMastH);
		}


		if(window_w >= 1200)
		{
			//Close mobile menu on desktop
			body.removeClass("mobile-menu-open");
			body.removeClass("megamobile");
			hamburger.removeClass("is-active");
			jQuery(".masthead-bottom").css({ height: 'auto'});
			jQuery("#header_menu").css({ height: 'auto'});
		}
		else if(window_w < 1200 && !hamburger.hasClass("is-active"))
		{
			// jQuery(".masthead-bottom").css({ height: '0'});
		}
	}

	function mobile_footer_dropdowns(){
		if(jQuery(".footer .menu_col .menu_heading").length)
		{
			jQuery(".footer .menu_col .menu_heading").click(function(e){
				if(verge.viewportW() < 1200)
				{
					if(!jQuery(this).hasClass("opened"))
					{
						jQuery(this).next().children(".menu").slideDown(400);
						jQuery(this).addClass("opened");
					}
					else
					{
						jQuery(this).next().children(".menu").slideUp(400);
						jQuery(this).removeClass("opened");
					}
				}
			});
		}
	}

	mobile_menu();
	mobile_footer_dropdowns();

	// ============ RESIZE EVENTS ============ //

	jQuery(window).resize(function(){
		if(jQuery(".mobile-menu-open").length && verge.viewportW() > 1200)
		{
			jQuery("body").removeClass("mobile-menu-open");
			body.removeClass("respo-search-closed");
		}

		set_mobile_menuH();
	});

}); // document.ready

