<?php
global $theme_options;

if (WP_VERSION < 3.0) {
	$theme_options = array (
		array(	
		'name'	=>	__('Footer', THEME_NS),
		'type'	=>	'heading'
		),
		array(	
		'id'	=>	'theme_footer_content',
		'name'	=>	__('Footer content', THEME_NS),
		'desc'	=>	sprintf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', THEME_NS), 'a, abbr, acronym, em, b, i, strike, strong, span') . '<br />'
	   			. sprintf(__('<strong>ShortTags:</strong><code>%s</code>', THEME_NS), '[year], [top], [rss], [login-link], [blog-title], [xhtml], [css]'),
		'type'	=>	'textarea'
		)
	);
	return;
}

$theme_menu_source_options = array(
	'Pages'	=>	__('Pages', THEME_NS),
	'Categories'	=>	__('Categories', THEME_NS)
);

$theme_sidebars_style_options = array(
	'block'	=>	__('Block style', THEME_NS),
	'post'	=>	__('Post style', THEME_NS),
	'simple'	=>	__('Simple text', THEME_NS)
);

$theme_heading_options = array(
	'h1'	=>	__('<H1>', THEME_NS),
	'h2'	=>	__('<H2>', THEME_NS),
	'h3'	=>	__('<H3>', THEME_NS),
	'h4'	=>	__('<H4>', THEME_NS),
	'h5'	=>	__('<H5>', THEME_NS),
	'h6'	=>	__('<H6>', THEME_NS),
	'div'	=>	__('<DIV>', THEME_NS),
);

$theme_hometype_options = array(
	'0'	=>	__('multi thum', THEME_NS),
	'1'	=>	__('list type', THEME_NS),
);

foreach(get_the_category() as $theme_category)
{
   $theme_cata_lists .= $theme_category->name . '['. $theme_category->cat_ID .'] | ';
}

global $theme_options;
$theme_options = array (
	array(	
	'name'	=>	__('General', THEME_NS),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'theme_index_type',
	'name'	=>	__('Home Page Type', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_hometype_options,
	'desc'	=>	__('Home page display type 1->list type; 0->multi thum', THEME_NS),
	),
	array(	
	'id'	=>	'theme_homepage_display_cataid',
	'name'	=>	__('Homepage display post by catagory id', THEME_NS),
	'type'	=>	'text',
	'desc'	=>	sprintf(__('<br><strong>Example : </strong> Input "1,3,5" this catagory willbe display in home page. left empty this option will be disable <p> catagory list : %s', THEME_NS),$theme_cata_lists),
	),
	array(	
	'id'	=>	'theme_homepage_display_cataid_num',
	'name'	=>	__('Homepage display how many post by catagory id', THEME_NS),
	'type'	=>	'text',
	'desc'	=>	sprintf(__('<br><strong>Example : </strong> Default: 20 ', THEME_NS)),
	),
	array(	
	'id'	=>	'theme_header_show_headline',
	'name'	=>	__('Show headline', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_header_show_slogan',
	'name'	=>	__('Show slogan', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_header_logo',
	'name'	=>	__('Header Logo', THEME_NS),
	'desc'	=>	sprintf(__('<br><strong>Example : </strong> http://www.example.com/path/of/image/logo.jpg ,You can use these Logo url', THEME_NS)),
	'type'	=>	'text'
	),
	array(	
	'id'	=>	'theme_header_content',
	'name'	=>	__('Header content', THEME_NS),
	'desc'	=>	sprintf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', THEME_NS), 'a, abbr, acronym, em, b, i, strike, strong, span') . '<br />'
	   		. sprintf(__('<strong>ShortTags:</strong><code>%s</code>', THEME_NS), '[year], [top], [rss], [login-link], [blog-title], [xhtml], [css]'),
	'type'	=>	'textarea'
	),
	array(	
	'id'	=>	'theme_footer_content',
	'name'	=>	__('Footer content', THEME_NS),
	'desc'	=>	sprintf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', THEME_NS), 'a, abbr, acronym, em, b, i, strike, strong, span') . '<br />'
	   		. sprintf(__('<strong>ShortTags:</strong><code>%s</code>', THEME_NS), '[year], [top], [rss], [login-link], [blog-title], [xhtml], [css]'),
	'type'	=>	'textarea'
	),
	array(	
	'id'	=>	'theme_show_random_posts_on_404_page',
	'name'	=>	__('Show random posts on 404 page', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_show_random_posts_title_on_404_page',
	'name'	=>	__('Title for random posts', THEME_NS),
	'type'	=>	'text',
	'desc'	=>	__('Used when "Show random posts on 404 page" is enabled', THEME_NS)
	),
	array(	
	'id'	=>	'theme_show_tags_on_404_page',
	'name'	=>	__('Show tags on 404 page', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_show_tags_title_on_404_page',
	'name'	=>	__('Title for tags', THEME_NS),
	'type'	=>	'text',
	'desc'	=>	__('Used when "Show tags on 404 page" is enabled', THEME_NS)
	),
	array(	
	'name'	=>	__('Ads Scripts', THEME_NS),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'theme_header_bottom_ads',
	'name'	=>	__('Header Bottom Ads Content', THEME_NS),
	'desc'	=>	sprintf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', THEME_NS), 'a, abbr, acronym, em, b, i, strike, strong, span') . '<br />'
	   		. sprintf(__('<strong>ShortTags:</strong><code>%s</code>', THEME_NS), '[year], [top], [rss], [login-link], [blog-title], [xhtml], [css]'),
	'type'	=>	'textarea'
	),
	array(	
	'id'	=>	'theme_show_header_bottom_ads',
	'name'	=>	__('Show Header Bottom Ads', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_single_artcle_ads',
	'name'	=>	__('Single Artcle Ads Content', THEME_NS),
	'desc'	=>	sprintf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', THEME_NS), 'a, abbr, acronym, em, b, i, strike, strong, span') . '<br />'
	   		. sprintf(__('<strong>ShortTags:</strong><code>%s</code>', THEME_NS), '[year], [top], [rss], [login-link], [blog-title], [xhtml], [css]'),
	'type'	=>	'textarea'
	),	
	array(	
	'id'	=>	'theme_show_single_artcle_ads',
	'name'	=>	__('Show Single Artcle Ads', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'name'	=>	__('Navigation Menu', THEME_NS),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'theme_menu_showHome',
	'name'	=>	__('Show home item', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_menu_homeCaption',
	'name'	=>	__('Home item caption', THEME_NS),
	'type'	=>	'text'
	),
	array(	
	'id'	=>	'theme_menu_highlight_active_categories',
	'name'	=>	__('Highlight active categories', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	
	array(	
	'id'	=>	'theme_menu_trim_title',
	'name'	=>	__('Trim long menu items', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),	
	array(	
	'id'	=>	'theme_menu_trim_len',
	'name'	=>	__('Limit each item to [N] characters', THEME_NS),
	'desc'	=>	__('(characters).', THEME_NS),
	'type'	=>	'numeric'
	),
	
	array(	
	'id'	=>	'theme_submenu_trim_len',
	'name'	=>	__('Limit each subitem to [N] characters', THEME_NS),
	'desc'	=>	__('(characters).', THEME_NS),
	'type'	=>	'numeric'
	),
	
	array(	
	'id'	=>	'theme_menu_source',
	'name'	=>	__('Default menu source', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_menu_source_options,
	'desc'	=>	__('Displayed when Appearance > Menu > Primary menu is not set', THEME_NS),
	),
	array(	
	'name'	=>	__('Posts', THEME_NS),
	'type'	=>	'heading'
	),

	array(	
	'id'	=>	'theme_home_top_posts_navigation',
	'name'	=>	__('Show navigation links at the top of front posts page', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),	

	array(	
	'id'	=>	'theme_top_posts_navigation',
	'name'	=>	__('Show navigation links at the top of posts page', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),

	array(	
	'id'	=>	'theme_bottom_posts_navigation',
	'name'	=>	__('Show navigation links at the bottom of posts page', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),

	array(	
	'id'	=>	'theme_top_single_navigation',
	'name'	=>	__('Show top navigation links in single post view', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_bottom_single_navigation',
	'name'	=>	__('Show bottom navigation links in single post view', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_single_navigation_trim_title',
	'name'	=>	__('Trim long navigation links in single post view', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),	
	array(	
	'id'	=>	'theme_single_navigation_trim_len',
	'name'	=>	__('Limit each link to [N] characters', THEME_NS),
	'desc'	=>	__('(characters).', THEME_NS),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'theme_allow_comments',
	'name'	=>	__('Allow Comments', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_comment_use_smilies',
	'name'	=>	__('Use smilies in comments', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_posts_headline_tag',
	'name'	=>	__('Tag for the posts headline', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_heading_options
	),
	array(	
	'id'	=>	'theme_posts_slogan_tag',
	'name'	=>	__('Tag for the posts slogan', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_heading_options
	),
	array(	
	'id'	=>	'theme_posts_article_title_tag',
	'name'	=>	__('Tag for the posts article', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_heading_options
	),
	array(	
	'id'	=>	'theme_posts_widget_title_tag',
	'name'	=>	__('Tag for the posts widgets', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_heading_options
	),
	array(	
	'id'	=>	'theme_single_headline_tag',
	'name'	=>	__('Tag for the headline', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_heading_options
	),
	array(	
	'id'	=>	'theme_single_slogan_tag',
	'name'	=>	__('Tag for the single slogan', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_heading_options
	),
	array(	
	'id'	=>	'theme_single_article_title_tag',
	'name'	=>	__('Tag for the single article title', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_heading_options
	),
	array(	
	'id'	=>	'theme_single_widget_title_tag',
	'name'	=>	__('Tag for the single widgets title', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_heading_options
	),
	array(	
	'name'	=>	__('HOME Setting', THEME_NS),
	'type'	=>	'heading'
	),
	array(	
	'id'	=>	'theme_metadata_use_featured_image_as_thumbnail',
	'name'	=>	__('Use featured image as thumbnail', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_metadata_thumbnail_auto',
	'name'	=>	__('Use auto thumbnails', THEME_NS),
	'desc'	=>	__('Generate post thumbnails automatically (use the first image from the post gallery)', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_metadata_thumbnail_width',
	'name'	=>	__('Thumbnail width', THEME_NS),
	'desc'	=>	__('(px)', THEME_NS),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'theme_metadata_thumbnail_height',
	'name'	=>	__('Thumbnail height', THEME_NS),
	'desc'	=>	__('(px)', THEME_NS),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'theme_metadata_excerpt_auto',
	'name'	=>	__('Use auto excerpts', THEME_NS),
	'desc'	=>	__('Generate post excerpts automatically (When neither more-tag nor post excerpt is used)', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_metadata_excerpt_words',
	'name'	=>	__('Excerpt length', THEME_NS),
	'desc'	=>	__('(words)', THEME_NS),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'theme_metadata_excerpt_min_remainder',
	'name'	=>	__('Excerpt balance', THEME_NS),
	'desc'	=>	__('(words)', THEME_NS),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'theme_metadata_excerpt_use_tag_filter',
	'name'	=>	__('Apply excerpt tag filter', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_metadata_excerpt_allowed_tags',
	'name'	=>	__('Allowed excerpt tags', THEME_NS),
	'desc'	=>	__('Used when "Apply excerpt tag filter" is enabled', THEME_NS),
	'type'	=>	'widetext'
	),
	array(	
	'name'	=>	__('Sidebars', THEME_NS),
	'type'	=>	'heading',
	'desc' => __('Default widgets style', THEME_NS)
	),
	array(	
	'id'	=>	'theme_sidebars_style_default',
	'name'	=>	__('Primary sidebar', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_sidebars_style_options
	),
	array(	
	'id'	=>	'theme_sidebars_style_secondary',
	'name'	=>	__('Secondary sidebar', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_sidebars_style_options
	),
	array(	
	'id'	=>	'theme_sidebars_style_top',
	'name'	=>	__('Top sidebars', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_sidebars_style_options
	),
	array(	
	'id'	=>	'theme_sidebars_style_bottom',
	'name'	=>	__('Bottom sidebars', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_sidebars_style_options
	),
	array(	
	'id'	=>	'theme_sidebars_style_footer',
	'name'	=>	__('Footer sidebars', THEME_NS),
	'type'	=>	'select',
	'options'	=>	$theme_sidebars_style_options
	),
	array(	
	'name'	=>	__('Advertisement', THEME_NS),
	'type'	=>	'heading',
	'desc' => sprintf(__('Use the %s short code to insert these ads into posts, text widgets or footer', THEME_NS),'<code>[ad]</code>') . '<br/>'
		. '<span>' . __('Example:', THEME_NS) .'</span><code>[ad code=4 align=center]</code>'
	),
	array(	
	'id'	=>	'theme_ad_code_1',
	'name'	=>	sprintf(__('Ad code #%s:', THEME_NS),1),
	'type'	=>	'textarea',
	'desc'  => sprintf(__('Use the %s short code to insert these ads into posts, text widgets or footer', THEME_NS),'<code>[ad]</code>') . '<br/>'
		. '<span>' . __('Example:', THEME_NS) .'</span><code>[ad code=4 align=center]</code>'
	),
	array(	
	'id'	=>	'theme_ad_code_2',
	'name'	=>	sprintf(__('Ad code #%s:', THEME_NS),2),
	'type'	=>	'textarea'
	),
	array(	
	'id'	=>	'theme_ad_code_3',
	'name'	=>	sprintf(__('Ad code #%s:', THEME_NS),3),
	'type'	=>	'textarea'
	),
	array(	
	'id'	=>	'theme_ad_code_4',
	'name'	=>	sprintf(__('Ad code #%s:', THEME_NS),4),
	'type'	=>	'textarea'
	),
	array(	
	'name'	=>	__('SEO Optimization ', THEME_NS),
	'type'	=>	'heading'
	),
  array(	
	'id'	=>	'theme_seo_keyword',
	'name'	=>	__('SEO Keyword', THEME_NS),
	'desc'	=>	sprintf(__('<br><strong>Example : </strong>  Keyword_1,Keyword_2,Keyword_3 You can use these SEO keyword.', THEME_NS)),
	'type'	=>	'text'
	),
	array(	
	'id'	=>	'theme_seo_auto_link_enable',
	'name'	=>	__('Enable SEO Auto Link', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_seo_link_num_min',
	'name'	=>	__('Min SEO Auto Link', THEME_NS),
	'desc'	=>	__('Limit min [N] link for each keyword', THEME_NS),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'theme_seo_link_num_max',
	'name'	=>	__('Max SEO Auto Link', THEME_NS),
	'desc'	=>	__('Limit max [N] link for each keyword', THEME_NS),
	'type'	=>	'numeric'
	),
	array(	
	'id'	=>	'theme_seo_auto_link_content',
	'name'	=>	__('SEO Auto Link content', THEME_NS),
	'desc'	=>	sprintf(__('<strong>Example:</strong> You can use these SEO format: keyword|max_link_num|link_url, with "|"', THEME_NS)) . '<br />',
	'type'	=>	'textarea'
	)
);

global $theme_page_meta_options;
$theme_page_meta_options = array (
	array(	
	'id'	=>	'theme_show_in_menu',
	'name'	=>	__('Show in Menu', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_show_as_separator',
	'name'	=>	__('Show as Separator in Menu', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	),
	array(	
	'id'	=>	'theme_title_in_menu',
	'name'	=>	__('Title in Menu', THEME_NS),
	'type'	=>	'text'
	),
	array(	
	'id'	=>	'theme_show_page_title',
	'name'	=>	__('Show Title on Page', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	)
);

global $theme_post_meta_options;
$theme_post_meta_options = array(
	array(	
	'id'	=>	'theme_show_post_title',
	'name'	=>	__('Show Title on Single Page', THEME_NS),
	'desc'	=>	__('Yes', THEME_NS),
	'type'	=>	'checkbox'
	)
);