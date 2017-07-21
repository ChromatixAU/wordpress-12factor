
/* ********************** Scripts for custom theme - login page ********************* */

jQuery(document).ready(function(){

	// wrap icwp checkbox with a label, because it's annoying otherwise!
	
		jQuery("input[type='checkbox'][id*='icwp-']").parent().wrapInner("<label></label>");
	
});

/* ************************************ The end! ************************************ */
