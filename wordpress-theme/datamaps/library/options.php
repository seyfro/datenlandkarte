<?php
global $art_options;

if (version_compare(WP_VERSION, '3.0', '<')) {
	$art_options = array (
		array(	
		'name'	=>	__('Footer'),
		'type'	=>	'heading'
		),
		array(	
		'id'	=>	'art_footer_content',
		'name'	=>	__('Footer content'),
		'desc'	=>	sprintf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>'), 'a, abbr, acronym, em, b, i, strike, strong, span') . '<br />'
	   			. sprintf(__('<strong>ShortTags:</strong><code>%s</code>'), '[year], [top], [rss], [login-link], [blog-title], [xhtml], [css]'),
		'type'	=>	'textarea'
		)
	);
	return;
}

$art_menu_source_options = array(
	'Pages'	=>	'Pages',
	'Categories'	=>	'Categories'
);

$art_sidebars_style_options = array(
	'block'	=>	'Block style',
	'post'	=>	'Post style',
	'simple'	=>	'Simple text'
);

global $art_options;
$art_options = array (
	array(	
	'name'	=>	__('Header'),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'art_header_show_headline',
	'name'	=>	__('Show headline'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_header_show_slogan',
	'name'	=>	__('Show slogan'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'name'	=>	__('Navigation Menu'),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'art_menu_showHome',
	'name'	=>	__('Show home item'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_menu_homeCaption',
	'name'	=>	__('Home item caption'),
	'type'	=>	'text'
	),
	array(	
	'id'	=>	'art_menu_highlight_active_categories',
	'name'	=>	__('Highlight active categories'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	
	array(	
	'id'	=>	'art_menu_trim_title',
	'name'	=>	__('Trim long menu items'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),	
	array(	
	'id'	=>	'art_menu_trim_len',
	'name'	=>	__('Limit each item to [N] characters'),
	'desc'	=>	__('(characters).'),
	'type'	=>	'numeric'
	),
	
	array(	
	'id'	=>	'art_submenu_trim_len',
	'name'	=>	__('Limit each subitem to [N] characters'),
	'desc'	=>	__('(characters).'),
	'type'	=>	'numeric'
	),
	
	array(	
	'id'	=>	'art_menu_source',
	'name'	=>	__('Default menu source'),
	'type'	=>	'select',
	'options'	=>	$art_menu_source_options,
	'desc'	=>	__('Displayed when Appearance > Menu > Primary menu is not set'),
	),
	array(	
	'name'	=>	__('Posts'),
	'type'	=>	'heading'
	),

	array(	
	'id'	=>	'art_home_top_posts_navigation',
	'name'	=>	__('Show navigation links at the top of front posts page'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),	

	array(	
	'id'	=>	'art_top_posts_navigation',
	'name'	=>	__('Show navigation links at the top of posts page'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),

	array(	
	'id'	=>	'art_bottom_posts_navigation',
	'name'	=>	__('Show navigation links at the bottom of posts page'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),

	array(	
	'id'	=>	'art_top_single_navigation',
	'name'	=>	__('Show top navigation links in single post view'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_bottom_single_navigation',
	'name'	=>	__('Show bottom navigation links in single post view'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_single_navigation_trim_title',
	'name'	=>	__('Trim long navigation links in single post view'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),	
	array(	
	'id'	=>	'art_single_navigation_trim_len',
	'name'	=>	__('Limit each link to [N] characters'),
	'desc'	=>	__('(characters).'),
	'type'	=>	'numeric'
	),
	
	array(	
	'name'	=>	__('Featured Image'),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'art_metadata_thumbnail_auto',
	'name'	=>	__('Use auto thumbnails'),
	'desc'	=>	__('Generate post thumbnails automatically (use the first image from the post gallery)'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_metadata_thumbnail_width',
	'name'	=>	__('Thumbnail width'),
	'desc'	=>	__('(px)'),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'art_metadata_thumbnail_height',
	'name'	=>	__('Thumbnail height'),
	'desc'	=>	__('(px)'),
	'type'	=>	'numeric'
	),
	array(	
	'name'	=>	__('Excerpt'),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'art_metadata_excerpt_auto',
	'name'	=>	__('Use auto excerpts'),
	'desc'	=>	__('Generate post excerpts automatically (When neither more-tag nor post excerpt is used)'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_metadata_excerpt_words',
	'name'	=>	__('Excerpt length'),
	'desc'	=>	__('(words)'),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'art_metadata_excerpt_min_remainder',
	'name'	=>	__('Excerpt balance'),
	'desc'	=>	__('(words)'),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'art_metadata_excerpt_use_tag_filter',
	'name'	=>	__('Apply excerpt tag filter'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_metadata_excerpt_allowed_tags',
	'name'	=>	__('Allowed excerpt tags'),
	'desc'	=>	__('Used when "Apply excerpt tag filter" is enabled'),
	'type'	=>	'widetext'
	),
	array(	
	'name'	=>	__('Pages'),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'art_show_random_posts_on_404_page',
	'name'	=>	__('Show random posts on 404 page'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_show_random_posts_title_on_404_page',
	'name'	=>	__('Title for random posts'),
	'type'	=>	'text',
	'desc'	=>	__('Used when "Show random posts on 404 page" is enabled')
	),
	array(	
	'id'	=>	'art_show_tags_on_404_page',
	'name'	=>	__('Show tags on 404 page'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_show_tags_title_on_404_page',
	'name'	=>	__('Title for tags'),
	'type'	=>	'text',
	'desc'	=>	__('Used when "Show tags on 404 page" is enabled')
	),
	array(	
	'name'	=>	__('Comments'),
	'type'	=>	'heading',
	),
	array(	
	'id'	=>	'art_comment_use_smilies',
	'name'	=>	__('Use smilies in comments'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'name'	=>	__('Sidebars'),
	'type'	=>	'heading',
	'desc' => __('Default widgets style')
	),
	array(	
	'id'	=>	'art_sidebars_style_default',
	'name'	=>	__('Primary sidebar'),
	'type'	=>	'select',
	'options'	=>	$art_sidebars_style_options
	),
	array(	
	'id'	=>	'art_sidebars_style_secondary',
	'name'	=>	__('Secondary sidebar'),
	'type'	=>	'select',
	'options'	=>	$art_sidebars_style_options
	),
	array(	
	'id'	=>	'art_sidebars_style_top',
	'name'	=>	__('Top sidebars'),
	'type'	=>	'select',
	'options'	=>	$art_sidebars_style_options
	),
	array(	
	'id'	=>	'art_sidebars_style_bottom',
	'name'	=>	__('Bottom sidebars'),
	'type'	=>	'select',
	'options'	=>	$art_sidebars_style_options
	),
	array(	
	'id'	=>	'art_sidebars_style_footer',
	'name'	=>	__('Footer sidebars'),
	'type'	=>	'select',
	'options'	=>	$art_sidebars_style_options
	),
	array(	
	'name'	=>	__('Footer'),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'art_footer_content',
	'name'	=>	__('Footer content'),
	'desc'	=>	sprintf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>'), 'a, abbr, acronym, em, b, i, strike, strong, span') . '<br />'
	   		. sprintf(__('<strong>ShortTags:</strong><code>%s</code>'), '[year], [top], [rss], [login-link], [blog-title], [xhtml], [css]'),
	'type'	=>	'textarea'
	),
	array(	
	'name'	=>	__('Advertisment'),
	'type'	=>	'heading',
	'desc' => sprintf(__('Use the %s short code to insert these ads into posts, text widgets or footer'),'<code>[ad]</code>') . '<br/>'
		. '<span>' . __('Example:') .'</span><code>[ad code=4 align=center]</code>'
	),
	array(	
	'id'	=>	'art_ad_code_1',
	'name'	=>	sprintf(__('Ad code #%s:'),1),
	'type'	=>	'textarea'
	),
	array(	
	'id'	=>	'art_ad_code_2',
	'name'	=>	sprintf(__('Ad code #%s:'),2),
	'type'	=>	'textarea'
	),
	array(	
	'id'	=>	'art_ad_code_3',
	'name'	=>	sprintf(__('Ad code #%s:'),3),
	'type'	=>	'textarea'
	),
	array(	
	'id'	=>	'art_ad_code_4',
	'name'	=>	sprintf(__('Ad code #%s:'),4),
	'type'	=>	'textarea'
	),
	array(	
	'id'	=>	'art_ad_code_5',
	'name'	=>	sprintf(__('Ad code #%s:'),5),
	'type'	=>	'textarea'
	)
);

global $art_page_meta_options;
$art_page_meta_options = array (
	array(	
	'id'	=>	'art_show_in_menu',
	'name'	=>	__('Show in Menu'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'art_title_in_menu',
	'name'	=>	__('Title in Menu'),
	'type'	=>	'text'
	),
	array(	
	'id'	=>	'art_show_page_title',
	'name'	=>	__('Show Title on Page'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	)
);

global $art_post_meta_options;
$art_post_meta_options = array(
	array(	
	'id'	=>	'art_show_post_title',
	'name'	=>	__('Show Title on Single Page'),
	'desc'	=>	__('Yes'),
	'type'	=>	'checkbox'
	)
);
