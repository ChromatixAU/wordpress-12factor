<?php function chr_customize_register($wp_customize){

	// ========================================
	// Header Social Media Section       
	// ========================================

	// $wp_customize->add_section(
	// 	'section_one',
	// 	array(
	// 		'title' => 'Header Social Media Links',
	// 		'description' => 'These fields allows you to add social media links to those of which you use',
	// 		'priority' => 35,
	// 	)
	// );

	// ===============================
	//  Facebook      
	// ===============================

	// Checkbox

	// $wp_customize->add_setting(
	// 	'facebook',
	// 	array(
	// 		'default' => false,
	// 	)
	// );

	// $wp_customize->add_control(
	// 	'facebook_ctrl', 
	// 	array(
	// 	'label'   => 'Include Facebook',
	// 	'section' => 'section_one',
	// 	'settings' => 'facebook',
	// 	'type'    => 'checkbox',
	// 	) 
	// );

}

add_action('customize_register','chr_customize_register');

?>