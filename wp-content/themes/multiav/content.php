<?php
	
/**
 *
 * content*.php
 *
 * The post format template. You can change the structure of your posts or add/remove post elements here.
 * 
 * 'id' - post id
 * 'class' - post class
 * 'thumbnail' - post icon
 * 'title' - post title
 * 'before' - post header metadata
 * 'content' - post content
 * 'after' - post footer metadata
 * 
 * To create a new custom post format template you must create a file "content-YourTemplateName.php"
 * Then copy the contents of the existing content.php into your file and edit it the way you want.
 * 
 * Change an existing get_template_part() function as follows:
 * get_template_part('content', 'YourTemplateName');
 *
 */	

	global $post;
	$index_post_title = '<a href="' . get_permalink( $post->ID ) . '" rel="bookmark" title="' . strip_tags(get_the_title()) . '"><b style="font-size:15px">'.get_the_title(). '</b></a><br> ' ;
	/*-----------------------------------------
	 * 如果要生成首页多图方式 
	 * 1:列表模式 ; 
	 * 0:首页多图方式
	-----------------------------------------*/
	if (theme_get_option('theme_index_type') == "1") {
	if (theme_get_option('theme_metadata_excerpt_auto')) {
		$index_content = cut_str(strip_tags(apply_filters('the_content', $post->post_content)), theme_get_option('theme_metadata_excerpt_words'),'...');
	theme_post_wrapper(
		array(
				'id' => theme_get_post_id(), 
				'class' => theme_get_post_class(),
				'thumbnail' => theme_get_post_thumbnail(),
				'title' => '', 
        'heading' => theme_get_option('theme_'.(is_single()?'single':'posts').'_article_title_tag'),
				'before' => theme_get_metadata_icons( '', 'header' ),
				'content' => $index_post_title . $index_content.'<div class="clear">'.theme_get_metadata_icons( 'tag,comments,read_more', 'footer' ).'</div>',
				'after' =>  ''
		)
	);
	}
	else {
	theme_post_wrapper(
		array(
				'id' => theme_get_post_id(), 
				'class' => theme_get_post_class(),
				'thumbnail' => theme_get_post_thumbnail(),
				'title' => theme_get_meta_option($post->ID, 'theme_show_post_title') ? '<a href="' . get_permalink( $post->ID ) .'">'. get_the_title() ."</a>" : '', 
        'heading' => theme_get_option('theme_'.(is_single()?'single':'posts').'_article_title_tag'),
				'before' => theme_get_metadata_icons( 'date,tag,sharecode', 'header' ),
				'content' => theme_get_content(),
				'after' =>  theme_get_metadata_icons( 'tag,comments', 'footer' )
		)
	);
	}
} elseif (theme_get_option('theme_index_type') == "0") {
	if (theme_get_option('theme_metadata_excerpt_auto')) {
		$index_content = "";
	theme_multithum_wrapper(
		array(
				'id' => theme_get_post_id(), 
				'class' => theme_get_post_class(),
				'thumbnail' => theme_get_post_thumbnail(),
				'title' => $index_post_title, 
        'heading' => theme_get_option('theme_'.(is_single()?'single':'posts').'_article_title_tag'),
				'before' => theme_get_metadata_icons( '', 'header' ),
				'content' => '',
				'after' =>  ''
		)
	);
	}	else {
	theme_multithum_wrapper(
		array(
				'id' => theme_get_post_id(), 
				'class' => theme_get_post_class(),
				'thumbnail' => theme_get_post_thumbnail(),
				'title' => theme_get_meta_option($post->ID, 'theme_show_post_title') ? '<a href="' . get_permalink( $post->ID ) .'">'. get_the_title() ."</a>" : '', 
        'heading' => theme_get_option('theme_'.(is_single()?'single':'posts').'_article_title_tag'),
				'before' => theme_get_metadata_icons( 'date,tag,sharecode', 'header' ),
				'content' => theme_get_content(),
				'after' =>  theme_get_metadata_icons( 'tag,comments', 'footer' )
		)
	);
	}
} ?>

