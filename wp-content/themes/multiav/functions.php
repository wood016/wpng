<?php
define('THEME_NAME',"multiav");
global $wp_version;
define('WP_VERSION', $wp_version);
define('THEME_NS', 'twentyten');
define('THEME_LANGS_FOLDER','/languages');
if (class_exists('xili_language')) {
	define('THEME_TEXTDOMAIN',THEME_NS);
} else {
	load_theme_textdomain(THEME_NS, TEMPLATEPATH . THEME_LANGS_FOLDER);
}

if (function_exists('mb_internal_encoding')) mb_internal_encoding(get_bloginfo('charset'));
if (function_exists('mb_regex_encoding')) mb_regex_encoding(get_bloginfo('charset'));

global $wp_locale;
if (isset($wp_locale)){
	$wp_locale->text_direction = 'ltr';
}

if (WP_VERSION < 3.0){
	require_once(TEMPLATEPATH . '/library/legacy.php');
}

theme_include_lib('defaults.php');
theme_include_lib('misc.php');
theme_include_lib('wrappers.php');
theme_include_lib('sidebars.php');
theme_include_lib('navigation.php');
theme_include_lib('shortcodes.php');
if (WP_VERSION >= 3.0) {
	theme_include_lib('widgets.php');
}

if (!function_exists('theme_favicon')) {
	function theme_favicon() { 
		if (is_file(TEMPLATEPATH .'/favicon.ico')):?>
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
		<?php endif;
	}
}
add_action('wp_head', 'theme_favicon');
add_action('admin_head', 'theme_favicon');
add_action('login_head', 'theme_favicon');

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'nav-menus' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
}
if (function_exists('register_nav_menus')) {
	register_nav_menus(array('primary-menu'	=>	__( 'Primary Navigation', THEME_NS)));
}


if(is_admin()){
	theme_include_lib('options.php');
	theme_include_lib('admins.php');
	function theme_add_option_page() {
		add_theme_page(__('Theme Options', THEME_NS), __('Theme Options', THEME_NS), 'edit_themes', basename(__FILE__), 'theme_print_options');
	} 
	add_action('admin_menu', 'theme_add_option_page');
	if (WP_VERSION >= 3.0) {
		add_action('sidebar_admin_setup', 'theme_widget_process_control');
		add_action('add_meta_boxes', 'theme_add_meta_boxes');
		add_action('save_post', 'theme_save_post');
	}
	return;
}


function theme_get_option($name){
	global $theme_default_options;
	$result = get_option($name);
	if ($result === false) {
		$result = theme_get_array_value($theme_default_options, $name);
	}
	return $result;
}



function theme_get_meta_option($id, $name){
	global $theme_default_meta_options;
	return theme_get_array_value(get_option($name), $id, theme_get_array_value($theme_default_meta_options, $name));
}



function theme_set_meta_option($id, $name, $value){
	$meta_option = get_option($name);
	if (!$meta_option || !is_array($meta_option)) {
		$meta_option = array();
	}
	$meta_option[$id] = $value;
	update_option($name, $meta_option);
}



function theme_get_post_id(){
	$post_id = get_the_ID();
	if($post_id != ''){
		$post_id = 'post-' . $post_id;
	}
	return $post_id;
}



function theme_get_post_class(){
	if (!function_exists('get_post_class')) return '';
	return implode(' ', get_post_class());
}


function theme_include_lib($name){
	if (function_exists('locate_template')){
		locate_template(array('library/'.$name), true);
	} else {
		theme_locate_template(array('library/'.$name), true);
	}
}


if (!function_exists('theme_get_metadata_icons')){
	function theme_get_metadata_icons($icons = '', $class=''){
		global $post;
		if (!is_string($icons) || theme_strlen($icons) == 0) return;
		$icons = explode(",", str_replace(' ', '', $icons));
		if (!is_array($icons) || count($icons) == 0) return;
		$result = array();
		for($i = 0; $i < count($icons); $i++){
			$icon = $icons[$i];
			switch($icon){
				case 'date':
					$result[] = '<span class="postdateicon">' . sprintf( __('<span class="%1$s">Published</span> %2$s', THEME_NS),
									'date',
									sprintf( '<span class="entry-date" title="%1$s">%2$s</span>',
										esc_attr( get_the_time() ),
										get_the_date()
									)
								) . '</span>';
				break;
				case 'author':
					$result[] = '<span class="postauthoricon">' . sprintf(__('<span class="%1$s">By</span> %2$s', THEME_NS),
									'author',
									sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
										get_author_posts_url( get_the_author_meta( 'ID' ) ),
										sprintf( esc_attr(__( 'View all posts by %s', THEME_NS )), get_the_author() ),
										get_the_author()
									)
								) . '</span>';
				break;
				case 'category':
					$categories = get_the_category_list(', ');
					if(theme_strlen($categories) == 0) break;
					$result[] = '<span class="postcategoryicon">' . sprintf(__('<span class="%1$s">Posted in</span> %2$s', THEME_NS), 'categories', get_the_category_list(', ')) . '</span>';
				break;
				case 'tag':
					$tags_list = get_the_tag_list( '', ', ' );
					if(!$tags_list) break;
					$result[] = '<span class="posttagicon">' . sprintf( __( '<span class="%1$s">Tagged</span> %2$s', THEME_NS ), 'tags', $tags_list ) . '</span>';
				break;
				case 'comments':
					if(!comments_open() || !theme_get_option('theme_allow_comments')) break;
					ob_start();
					comments_popup_link( __( 'Leave a comment', THEME_NS ), __( '1 Comment', THEME_NS ), __( '% Comments', THEME_NS ) );
					$result[] = '<span class="postcommentsicon">' . ob_get_clean() . '</span>';
				break;
				case 'edit':
					if (!current_user_can('edit_post', $post->ID)) break;
					ob_start();
					edit_post_link(__('Edit', THEME_NS), '');
					$result[] = '<span class="postediticon">' .ob_get_clean() . '</span>';
				break;
				case 'posts_link':
				  $posts_link = get_permalink($post->ID);
					if (! $posts_link ) break;
					ob_start();
					$result[] = '<span class="postlinkicon">' .sprintf(__('<span class="%1$s">Permalink:</span> <a href="%2$s">%3$s</a> [Reproduced, please indicate this source, and links to articles]', THEME_NS), 'Permalink', $posts_link,cut_str($posts_link,20,'...' )). '</span>';
				break;
				case 'read_more':
				  $posts_link = get_permalink($post->ID);
					if (! $posts_link ) break;
					ob_start();
					$result[] = '<span class="readmore">' .sprintf(__('<span class="%1$s"><a href="%2$s">Read More...</a> </span> ', THEME_NS), 'readmore', $posts_link ). '</span>';
				break;
				case 'sharecode':
					if(strlen($sharecode) == 0) {$sharecode = '<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-518cb104196644d7"></script>
<!-- AddThis Button END -->';}
					$result[] = '<span class="postshare">' . sprintf(__('<span class="%1$s"></span> %2$s', THEME_NS), 'sharecode', $sharecode) . '</span>';
				break;
			}
		}
    $result = implode(theme_get_option('theme_metadata_separator'), $result);
		if (theme_is_empty_html($result)) return;
		return "<div class=\"post{$class}icons metadata-icons\">{$result}</div>";
	}
}

if (!function_exists('theme_get_post_thumbnail')){
	function theme_get_post_thumbnail($args = array()){
		global $post;
		
		$size = theme_get_array_value($args, 'size', array(theme_get_option('theme_metadata_thumbnail_width'), theme_get_option('theme_metadata_thumbnail_height')));
		$auto = theme_get_array_value($args, 'auto', theme_get_option('theme_metadata_thumbnail_auto'));
		$featured = theme_get_array_value($args, 'featured', theme_get_option('theme_metadata_use_featured_image_as_thumbnail'));
		$title = theme_get_array_value($args, 'title', get_the_title());

		$result = '';

		if ($featured && (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {
			ob_start();
			the_post_thumbnail($size, array('alt'	=>	'', 'title'	=>	$title));
			$result = ob_get_clean();
		} elseif ($auto) {
			$attachments = get_children(array('post_parent'	=>	$post->ID, 'post_status'	=>	'inherit', 'post_type'	=>	'attachment', 'post_mime_type'	=>	'image', 'order'	=>	'ASC', 'orderby'	=>	'menu_order ID'));
			if($attachments) {
				$attachment = array_shift($attachments);
				$img = wp_get_attachment_image_src($attachment->ID, $size);
				if (empty($img[0])) {
					$img[0] = get_post_img_src();
				}
					$result = '<img src="'.$img[0].'" alt="'.$post->title.'" width="'.( $img[1] > 0 ? $img[1] : theme_get_option('theme_metadata_thumbnail_width') ).'" height="'.( $img[2] > 0 ? $img[2] : theme_get_option('theme_metadata_thumbnail_height') ).'" title="'.$title.'" class="wp-post-image" />';
			}
		}	
		if (!isset($img[0]) && $auto) {
				/*取文章中的图片URL*/
				$img = array ();
				$img[0] = get_post_img_src();
				$img[1] = theme_get_option('theme_metadata_thumbnail_width');
				$img[2] = theme_get_option('theme_metadata_thumbnail_height');
				$title  = get_the_title();
				if (isset($img[0])){
					$result = '<img src="'.$img[0].'" alt="'.$post->title.'" width="'.( $img[1] > 0 ? $img[1] : theme_get_option('theme_metadata_thumbnail_width') ).'" height="'.( $img[2] > 0 ? $img[2] : theme_get_option('theme_metadata_thumbnail_height') ).'" title="'.$title.'" class="wp-post-image" />';
					}
				}
		if($result !== ''){
			$result = '<div class="avatar alignleft"><a href="'.get_permalink($post->ID).'" title="'.$title.'">'.$result.'</a></div>';
		} else {
		  $result = '<div class="avatar alignleft"><a href="'.get_permalink($post->ID).'" title="'.$title.'">'.get_post_img_src().'</a></div>';	
		}
		return $result;
	}
}

if (!function_exists('theme_get_content')){
	function theme_get_content($args = array()) {
		$more_tag = theme_get_array_value($args, 'more_tag', __('Continue reading <span class="meta-nav">&rarr;</span>', THEME_NS));
		$content = get_the_content($more_tag);
		// hack for badly written plugins
		ob_start();echo apply_filters('the_content', $content);$content = ob_get_clean();
		return $content . wp_link_pages(array(
		'before' => '<p><span class="page-navi-outer page-navi-caption"><span class="page-navi-inner">' . __('Pages', THEME_NS) . ': </span></span>',
		'after' => '</p>',
		'link_before' => '<span class="page-navi-outer"><span class="page-navi-inner">',
		'link_after' => '</span></span>',
		'echo' => 0
		));
	}
}

if (!function_exists('theme_get_excerpt')){
	function theme_get_excerpt($args = array()) {
		global $post;
		$more_tag = theme_get_array_value($args, 'more_tag', __('Continue reading <span class="meta-nav">&rarr;</span>', THEME_NS));
		$auto = theme_get_array_value($args, 'auto', theme_get_option('theme_metadata_excerpt_auto'));
		$all_words = theme_get_array_value($args, 'all_words', theme_get_option('theme_metadata_excerpt_words'));
		$min_remainder = theme_get_array_value($args, 'min_remainder', theme_get_option('theme_metadata_excerpt_min_remainder'));
		$allowed_tags = theme_get_array_value($args, 'allowed_tags', 
			(theme_get_option('theme_metadata_excerpt_use_tag_filter') 
				? explode(',',str_replace(' ', '', theme_get_option('theme_metadata_excerpt_allowed_tags'))) 
				: null));
		$perma_link = get_permalink($post->ID);
		$more_token = '%%theme_more%%';
		$show_more_tag = false;
		$tag_disbalance = false;
		if (function_exists('post_password_required') && post_password_required($post)){
			return get_the_excerpt();
		}
		if ($auto && has_excerpt($post->ID)) {
			$excerpt = get_the_excerpt();
			$show_more_tag = theme_strlen($post->post_content) > 0;
		} else {
			$excerpt = get_the_content($more_token);
			// hack for badly written plugins
		    ob_start();echo apply_filters('the_content', $excerpt);$excerpt = ob_get_clean();
			global $multipage;
			if ($multipage && theme_strpos($excerpt, $more_token) === false){
				$show_more_tag = true;
			}
			if(theme_is_empty_html($excerpt)) return $excerpt;
			if ($allowed_tags !== null) {
				$allowed_tags = '<' .implode('><',$allowed_tags).'>';
				$excerpt = strip_tags($excerpt, $allowed_tags);
			}
			if (theme_strpos($excerpt, $more_token) !== false) {
				$excerpt = str_replace($more_token, $more_tag, $excerpt);
			} elseif($auto && is_numeric($all_words)) {
				$token = "%theme_tag_token%";
				$content_parts = explode($token, str_replace(array('<', '>'), array($token.'<', '>'.$token), $excerpt));
				$content = array();
				$word_count = 0;
				foreach($content_parts as $part)
				{
					if (theme_strpos($part, '<') !== false || theme_strpos($part, '>') !== false){
						$content[] = array('type'=>'tag', 'content'=>$part);
					} else {
						$all_chunks = preg_split('/([\s])/u', $part, -1, PREG_SPLIT_DELIM_CAPTURE);
						foreach($all_chunks as $chunk) {
							if('' != trim($chunk)) {
								$content[] = array('type'=>'word', 'content'=>$chunk);
								$word_count += 1;
							} elseif($chunk != '') {
								$content[] = array('type'=>'space', 'content'=>$chunk);
							}
						}
					}
				}

				if(($all_words < $word_count) && ($all_words + $min_remainder) <= $word_count) {
					$show_more_tag = true;
					$tag_disbalance = true;
					$current_count = 0;
					$excerpt = '';
					foreach($content as $node) {
						if($node['type'] == 'word') {
							$current_count++;
						} 
						$excerpt .= $node['content'];
						if ($current_count == $all_words){
							break;
						}
					}
					$excerpt .= '&hellip;'; // ...
				}
			}
		}
		if ($show_more_tag) {
			$excerpt = $excerpt.' <a class="more-link" href="'.$perma_link.'">'.$more_tag.'</a>';
		}
		if ($tag_disbalance) {
			$excerpt = force_balance_tags($excerpt);
		}
		return $excerpt;
	}
}

if (!function_exists('theme_get_search')){
	function theme_get_search(){
		ob_start();
		get_search_form();
		return ob_get_clean();
	}
}


function theme_is_home(){
	return (is_home() && !is_paged());
}


if (!function_exists('theme_404_content')){
	function theme_404_content($args = ''){
		$args = wp_parse_args($args, 
			array(
				'error_title' => __('Not Found', THEME_NS),
				'error_message' => __( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', THEME_NS),
				'focus_script' => '<script type="text/javascript">jQuery(\'div.content input[name="s"]\').focus();</script>'
			)
		);	
		extract($args);
		theme_post_wrapper(
			array(
					'title' => $error_title,
					'content' => '<p class="center">'. $error_message . '</p>' . "\n" . theme_get_search() . $focus_script
			)
		);
	    
		if (theme_get_option('theme_show_random_posts_on_404_page')){
			ob_start(); 
			echo '<h4 class="box-title">' . theme_get_option('theme_show_random_posts_title_on_404_page') . '</h4>'; ?>
			<ul>
				<?php
					global $post;
					$rand_posts = get_posts('numberposts=5&orderby=rand');
					foreach( $rand_posts as $post ) :
				?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php theme_post_wrapper(array('content' => ob_get_clean()));
		}
		if (theme_get_option('theme_show_tags_on_404_page')){
			ob_start();
			echo '<h4 class="box-title">' . theme_get_option('theme_show_tags_title_on_404_page') . '</h4>';
			wp_tag_cloud('smallest=9&largest=22&unit=pt&number=200&format=flat&orderby=name&order=ASC');
			theme_post_wrapper(array('content' => ob_get_clean()));
		}
	}
}

if (!function_exists('theme_page_navigation')){
	function theme_page_navigation($args = '') {
		$args = wp_parse_args($args, array('wrap' => true, 'prev_link' => false, 'next_link' => false));
		$prev_link = $args['prev_link'];
		$next_link = $args['next_link'];
		$wrap = $args['wrap'];
		if (!$prev_link && !$next_link) {
			if (function_exists('wp_page_numbers')) { // http://wordpress.org/extend/plugins/wp-page-numbers/
				ob_start();
				wp_page_numbers();
				theme_post_wrapper(array('content' => ob_get_clean()));
				return;
			} 
			if (function_exists('wp_pagenavi')) { // http://wordpress.org/extend/plugins/wp-pagenavi/
				ob_start();
				theme_post_wrapper(array('content' => ob_get_clean()));
				?>
				<div class="page_nav">
				<?php wp_pagenavi();?>
				</div>
				<?php
				return;
			} 
			//posts
			$prev_link = get_previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', THEME_NS));
			$next_link = get_next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', THEME_NS));
		}
		$content = '';
		$next_align = 'left';
		$prev_align = 'right';
		if (function_exists('is_rtl') && is_rtl()){
			$next_align = 'right';
			$prev_align = 'left';
		}
		if ($prev_link || $next_link) {
			$content = <<<EOL
		<div class="align{$next_align}">{$next_link}</div>
		<div class="align{$prev_align}">{$prev_link}</div>
EOL;
		}
		if ($wrap) {
			theme_post_wrapper(array('content' => $content));	
		} else {
			echo $content;
		}
	}
}

if (!function_exists('theme_get_previous_post_link')){

	function theme_get_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '') {
		return theme_get_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true);
	}
}

if (!function_exists('theme_get_next_post_link')){
	function theme_get_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '') {
		return theme_get_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false);
	}
}

if (!function_exists('theme_get_adjacent_image_link')){
	function theme_get_adjacent_image_link($prev = true, $size = 'thumbnail', $text = false) {
		global $post;
		$post = get_post($post);
		$attachments = array_values(get_children( array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') ));

		foreach ( $attachments as $k => $attachment )
			if ( $attachment->ID == $post->ID )
				break;

		$k = $prev ? $k - 1 : $k + 1;

		if ( isset($attachments[$k]) )
			return wp_get_attachment_link($attachments[$k]->ID, $size, true, false, $text);
	}
}

if (!function_exists('theme_get_previous_image_link')){
	function theme_get_previous_image_link($size = 'thumbnail', $text = false) {
		$result = theme_get_adjacent_image_link(true, $size, $text);
		if ($result) $result = '&laquo; ' . $result;
		return $result;
	}
}
	
if (!function_exists('theme_get_next_image_link')){
	function theme_get_next_image_link($size = 'thumbnail', $text = false) {
		$result = theme_get_adjacent_image_link(false, $size, $text);
		if ($result) $result .= ' &raquo;';
		return $result;
	}
}

if (!function_exists('theme_get_adjacent_post_link')){
	function theme_get_adjacent_post_link($format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true) {
		if ( $previous && is_attachment() )
			$post = & get_post($GLOBALS['post']->post_parent);
		else
			$post = get_adjacent_post($in_same_cat, $excluded_categories, $previous);

		if ( !$post )
			return;

		$title = strip_tags($post->post_title);

		if ( empty($post->post_title) )
			$title = $previous ? __('Previous Post', THEME_NS) : __('Next Post', THEME_NS);

		$title = apply_filters('the_title', $title, $post->ID);
		$short_title = $title;
		if (theme_get_option('theme_single_navigation_trim_title')) {
			$short_title = theme_trim_long_str($title, theme_get_option('theme_single_navigation_trim_len'));
		}
		$date = mysql2date(get_option('date_format'), $post->post_date);
		$rel = $previous ? 'prev' : 'next';

		$string = '<a href="'.get_permalink($post).'" title="'.esc_attr($title).'" rel="'.$rel.'">';
		$link = str_replace('%title', $short_title, $link);
		$link = str_replace('%date', $date, $link);
		$link = $string . $link . '</a>';

		$format = str_replace('%link', $link, $format);

		$adjacent = $previous ? 'previous' : 'next';
		return apply_filters( "{$adjacent}_post_link", $format, $link );
	}
}

if (!function_exists('get_previous_comments_link')) {
	function get_previous_comments_link($label)
	{
		ob_start();
		previous_comments_link($label);
		return ob_get_clean();
	}
}

if (!function_exists('get_next_comments_link')) {
	function get_next_comments_link($label)
	{
		ob_start();
		next_comments_link($label);
		return ob_get_clean();
	}
}

if (!function_exists('theme_comment')){
	function theme_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		
		
		switch ( $comment->comment_type ) :
		
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<?php ob_start(); ?>
			<div class="comment-author vcard">
				<?php echo theme_get_avatar(array('id' => $comment, 'size' => 48)); ?>
				<?php printf( __( '%s <span class="says">says:</span>', THEME_NS ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', THEME_NS); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					printf( __( '%1$s at %2$s', THEME_NS ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', THEME_NS), ' ' );
				?>
			</div>

			<div class="comment-body"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
			<?php theme_post_wrapper(array('content' => ob_get_clean(), 'id' => 'comment-'.get_comment_ID())); ?>


		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
		<?php ob_start(); ?>
			<p><?php _e( 'Pingback:', THEME_NS ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', THEME_NS), ' ' ); ?></p>
		<?php theme_post_wrapper(array('content' => ob_get_clean(), 'class' => $comment->comment_type));
				break;
		endswitch;
	}
}

if (!function_exists('theme_get_avatar')){
	function theme_get_avatar($args = ''){
	$args = wp_parse_args($args, array('id' => false, 'size' => 96, 'default' => '', 'alt' => false, 'url' => false));
	extract($args);
		$result = get_avatar($id, $size, $default, $alt);
		if ($result) {
			if ($url){
				$result = '<a href="'.esc_url($url).'">' . $result . '</a>';
			}
			$result = '<div class="avatar">' . $result . '</div>';
		}
		return $result;
	}
}

if (!function_exists('get_post_format')){
	function get_post_format(){
		return false;
	}
}

/*
支持中文截取长度
*/
function cut_str($sourcestr,$cutlength,$gnorechar)
{
$cutlength = strlen($cutlength) ? $cutlength : theme_get_option('theme_metadata_excerpt_words');
//$cutlength = theme_get_option('theme_metadata_excerpt_words');
$gnorechar = strlen($gnorechar) ? $gnorechar : '';
$returnstr='';
$i=0;
$n=0;
$str_length=strlen($sourcestr);//字符串的字节数
while (($n<$cutlength) and ($i<=$str_length))
{
$temp_str=substr($sourcestr,$i,1);
$ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
if ($ascnum>=224)    //如果ASCII位高与224，
{
$returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
$i=$i+3;            //实际Byte计为3
$n++;            //字串长度计1
}
elseif ($ascnum>=192) //如果ASCII位高与192，
{
$returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
$i=$i+2;            //实际Byte计为2
$n++;            //字串长度计1
}
elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
{
$returnstr=$returnstr.substr($sourcestr,$i,1);
$i=$i+1;            //实际的Byte数仍计1个
$n++;            //但考虑整体美观，大写字母计成一个高位字符
}
else                //其他情况下，包括小写字母和半角标点符号，
{
$returnstr=$returnstr.substr($sourcestr,$i,1);
$i=$i+1;            //实际的Byte数计1个
$n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽…
}
}
if ($str_length>$cutlength){
$returnstr = $returnstr . $gnorechar;//超过长度时在尾处加上省略号
}
return $returnstr;
}

/*
取文章中图片的URL
*/
function get_post_img_src() {
  global $post;
  //preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', stripcslashes($post->post_content), $matches);
  preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.bmp|\.jpeg|\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/", stripcslashes($post->post_content), $matches);
  $the_img = $matches [1][0];
  if(empty($the_img)) { 
  	//取目录thumbnail下的所有文件 BEGIN
		$thumb_rend = glob(TEMPLATEPATH."/thumbnail/*.*");
		$thumb_rend_id = array_rand($thumb_rend,1);
		$thumb_rend = $thumb_rend[$thumb_rend_id];
		$thumb_rend = str_replace( TEMPLATEPATH, get_bloginfo('template_url'),$thumb_rend);
		$the_img = $thumb_rend;	
    //取目录thumbnail下的所有文件 END
  }
  if(empty($the_img)){
  	$the_img = get_bloginfo('template_url').'/images/noimage.png';
  	//$the_img = str_replace( TEMPLATEPATH, get_bloginfo('template_url'),$the_img);
  }
  return $the_img;
}

if ( ! function_exists( 'theme_get_post_img_url' ) ) :
function theme_get_post_img_url() {
  global $post;
  //preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', stripcslashes($post->post_content), $matches);
  preg_match_all("/src=\"\/?(.*?)\"/", stripcslashes($post->post_content), $matches);
  $the_img = $matches [1][0];
  if(empty($the_img)) { 
  	//取目录thumbnail下的所有文件 BEGIN
		$thumb_rend = glob(TEMPLATEPATH."/thumbnail/*.*");
		$thumb_rend_id = array_rand($thumb_rend,1);
		$thumb_rend = $thumb_rend[$thumb_rend_id];
		$thumb_rend = str_replace( TEMPLATEPATH, get_bloginfo('template_url'),$thumb_rend);
		$the_img = $thumb_rend;	
    //取目录thumbnail下的所有文件 END
  }
  if(!empty($the_img)){
  return $the_img;
  }
}
endif;

function the_breadcrumb() {
	$space_char = '>>';
	echo __( 'Navigation:', THEME_NS ).'<a href='.get_option('home').'>'.__( 'HOME', THEME_NS ).'</a>';
	if (!is_home()) {
		//echo __( 'Navigation:', THEME_NS ).'<a href="'.get_option('home').'">'.get_bloginfo('name')."</a>";
		if (is_category() || is_single()) {
			echo $space_char ;
			the_category($space_char);
			if (is_single()) {
				echo $space_char ;
				the_title();
			}
		} elseif (is_page()) {
			echo $space_char ;
			echo the_title();
		}
	} 
}
####################################################################################################
#
#	分页代码
#
####################################################################################################
if (!function_exists('wp_pagenavi')) {
function wp_pagenavi( $p = 2 )
{
	if ( is_singular() ) return;
	global $wp_query, $paged;
	$max_page = $wp_query->max_num_pages;
	if ( $max_page == 1 ) return;
	if ( empty( $paged ) ) $paged = 1;
	echo '<span class="page-numbers">' . $paged . ' / ' . $max_page . ' </span> ';
	if ( $paged > 1 ) p_link( $paged - 1, __('&laquo; Previous'),__('&laquo; Previous') );
	if ( $paged > $p + 1 ) p_link( 1, 'First page' );
	if ( $paged > $p + 2 ) echo '<span class="page-numbers">...</span>';
	for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
		if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );
	}
	if ( $paged < $max_page - $p - 1 ) echo '<span class="page-numbers">...</span>';
	if ( $paged < $max_page - $p ) p_link( $max_page, 'Last page' );
	if ( $paged < $max_page ) p_link( $paged + 1, __('Next &raquo;'), __('Next &raquo;') );
}
function p_link( $i, $title = '', $linktype = '' )
{
	if ( $title == '' ) $title = "The {$i} page";
	if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
	echo "<a class='page-numbers' href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$linktext}</a> ";
}
}

/* 标题重写 */

if (!function_exists('title_seo')) {
function title_seo()
{
global $post;
$title = (theme_get_option('theme_seo_keyword')? theme_get_option('theme_seo_keyword').' | ' . get_bloginfo('name') : get_bloginfo('name'));
if (is_single()) {
  echo get_the_title().' | '. ((theme_strlen($categories) == 0) ? '' : get_the_category().' | ') . $title ;
}
elseif (is_category()){
  echo get_the_title().' | '. ((theme_strlen($categories) == 0) ? '' : get_the_category().' | ') . $title ;
}
else echo $title;
}
}

/* 描述重写 */
if (!function_exists('metadesc_seo')) {
function metadesc_seo()
{
global $post;
$metadesc = (theme_get_option('theme_seo_keyword')? theme_get_option('theme_seo_keyword').' | ' . get_bloginfo('name') : get_bloginfo('name'));
if (is_single()) {
  echo ((single_tag_title( '', false ))? single_tag_title( '', false ) .' | ' : '') .get_the_title().' | '. $metadesc ;
}
elseif (is_category()){
  echo ((single_cat_title( '', false ))? single_cat_title( '', false ) .' | ' : '') . $metadesc ;
}
else echo $metadesc;
}
}

/* 关键词重写 */

if (!function_exists('keyword_seo')) {
function keyword_seo()
{
global $post;
$metakeyword = (theme_get_option('theme_seo_keyword')? theme_get_option('theme_seo_keyword') : get_bloginfo('name'));
if (is_single()) {
  echo ((theme_strlen($categories) == 0) ? '' : get_the_category().' | ') . $metakeyword ;
}
elseif (is_category()){
  echo ((theme_strlen($categories) == 0) ? '' : get_the_category().' | ') . $metakeyword ;
}
else echo $metakeyword;
}
}

/* 用于SEO关键词的排序 */
if (!function_exists('tag_sort')) {
function seo_tag_sort($a, $b){
	if ( $a->name == $b->name ) return 0;
	return ( strlen($a->name) > strlen($b->name) ) ? -1 : 1;
}
}
/* 生成SEO关键词的链接 */
if (!function_exists('seo_tag_link')) {
function seo_tag_link($content)
{
	if ( theme_get_option('theme_seo_auto_link_enable') && theme_get_option('theme_seo_auto_link_content')) {
	$match_num_min = theme_get_option('theme_seo_link_num_min') ? theme_get_option('theme_seo_link_num_min') : 1;
	$match_num_max = theme_get_option('theme_seo_link_num_max') ? theme_get_option('theme_seo_link_num_max') : 1;
	if ( theme_get_option('theme_seo_auto_link_content') ) {
		$posttags = explode("\n", trim(theme_get_option('theme_seo_auto_link_content')));
	}
	//$posttags =  : get_the_tags();
	if ($posttags) {
		usort($posttags, "seo_tag_sort");
		foreach($posttags as $tag) {
			if (!empty($tag)) {
			list($keyword,$max_num,$link) = split("\|",$tag);
			
			//清理特殊字符$,增加转义字符
			$cleankeyword = stripslashes($keyword);
      $ex_word = addcslashes($cleankeyword, '$');
      
			//取已经做链接的关键词数量
			preg_match_all ('|(<a[^>]+>)([^<]*)('.$ex_word.')([^>]*)(</a[^>]*>)|U',$content,$key_matchs);
			$match_num_max = ( $max_num - count($key_matchs[0]) ) ? $max_num - count($key_matchs[0]) : 0;
			
			//生成连接代码
			$url = '<a href="'.$link.'" title="'.str_replace('%s',addcslashes($cleankeyword, '$'),__('Link to %s',THEME_NS)).'" target="_blank"';
			$url .= ">".addcslashes($cleankeyword, '$')."</a>";
      //只取完全匹配或前后有空格的关键词，
			$content = preg_replace( '|(<a[^>]+>)(.*)('.$ex_word.')(.*)(</a[^>]*>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
			$content = preg_replace( '|(<img)(.*?)('.$ex_word.')(.*?)(>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
		  if ( $match_num_max >=1 ) {
			$limit =  $match_num_max;
		  $cleankeyword = preg_quote($cleankeyword,'\'');
			$regEx = '\'(?!((<.*?)|(<a.*?)))('. $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;
			$content = preg_replace($regEx,$url,$content,$limit);
		  }
			//恢复原已经有链接的文本
			$content = str_replace( '%&&&&&%', stripslashes($ex_word), $content);
		  }
		}
	}
	}
  return $content; 
  
}
}