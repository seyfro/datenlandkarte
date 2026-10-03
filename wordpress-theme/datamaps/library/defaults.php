<?php
global $art_default_options;
$art_default_options = array(
	
	'art_header_show_headline'	=>	1,
	'art_header_show_slogan'	=>	1,
	
	'art_menu_showHome'	=>	1,
	'art_menu_highlight_active_categories'	=>	1,
	'art_menu_homeCaption'	=>	'Home',
	
	'art_menu_trim_title'=> 1,
	'art_menu_trim_len'=> 45,
	'art_submenu_trim_len'=> 40,

	'art_menu_depth'	=>	0,
	'art_menu_source'	=>	'Pages',
	
	'art_vmenu_depth'	=>	1,
	'art_vmenu_source'	=>	'Categories',
	
	'art_sidebars_style_default'	=>	'block',
	'art_sidebars_style_secondary'	=>	'block',
	'art_sidebars_style_top'	=>	'block',
	'art_sidebars_style_bottom'	=>	'block',
	'art_sidebars_style_footer'	=>	'simple',
	
	'art_metadata_thumbnail_auto'	=>	0,
	'art_metadata_thumbnail_width'	=>	100,
	'art_metadata_thumbnail_height'	=>	100,

	'art_metadata_separator'	=>	' | ',
	'art_metadata_excerpt_auto'	=>	0,
	'art_metadata_excerpt_min_remainder'	=>	5,
	'art_metadata_excerpt_words'	=>	40,
	'art_show_tags_on_404_page' => 0,
	'art_show_tags_title_on_404_page' => __('Tag Cloud'),
	'art_show_random_posts_on_404_page' => 0,
	'art_show_random_posts_title_on_404_page' => __('Random posts'),
	'art_comment_use_smilies' => 0,

	'art_metadata_excerpt_use_tag_filter'	=>	0,
	'art_metadata_excerpt_allowed_tags'	=> 'a, abbr, blockquote, b, cite, pre, code, em, label, i, p, strong, ul, ol, li, h1, h2, h3, h4, h5, h6, object, param, embed',

	'art_top_single_navigation'	=>	1,
	'art_bottom_single_navigation'	=>	0,
	'art_single_navigation_trim_title'	=>	1,
	'art_single_navigation_trim_len'	=>	80,
	
	'art_home_top_posts_navigation'	=>	0,
	'art_top_posts_navigation'	=>	1,
	'art_bottom_posts_navigation'	=>	1,
	'art_attachment_size' => 600,
	'art_footer_content'	=>	<<<EOL
<p><a href="#">Link1</a> | <a href="#">Link2</a> | <a href="#">Link3</a></p><p>Copyright © [year]. All Rights Reserved.</p>
EOL
);

global $art_default_meta_options;
$art_default_meta_options = array(
	'art_show_in_menu'	=>	1,
	'art_title_in_menu'	=>	'',
	'art_show_page_title'	=>	1,
	'art_show_post_title'	=>	1,
	'art_widget_styles'	=>	'default'
);
