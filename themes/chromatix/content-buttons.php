<?php
	//Simple generating of iedex buttons with ACF Repeaters
	$html = '';
	$text = get_sub_field( 'text' );
	$option = get_sub_field( 'link_option' );
	$page_link = get_sub_field( 'page_link' );
	$url = get_sub_field( 'external_link' );

	if($text && $option)
	{
		if($option == 'internal' && $page_link)
		{
			$html = '<a class="jacloc-button" title="'. $text . '" href="'. $page_link . '">' . $text . '</a>';
		}
		elseif($option == 'external' && $url)
		{
			$html = '<a class="jacloc-button" title="'. $text . '" target="_blank" href="'. $url . '">' . $text . '</a>';
		}
	}

	if(!empty($html))
	{
		echo $html;
	}