<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
<title><?php wp_title( '|', true, 'right' );  title_seo(); ?></title>
<meta name="description" content="<? metadesc_seo(); ?>" />
<meta name="keyword" content="<? keyword_seo();?>" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.ie7.css" type="text/css" media="screen" /><![endif]-->
<?php if ( is_single() || is_page() ): ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/image.css" type="text/css" media="screen" />
<?php endif; ?>
<?php if ( is_page() ): ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/page.css" type="text/css" media="screen" />
<?php endif; ?>
<?php if(WP_VERSION < 3.0): ?>
<link rel="alternate" type="application/rss+xml" title="<?php printf(__('%s RSS Feed', THEME_NS), get_bloginfo('name')); ?>" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php printf(__('%s Atom Feed', THEME_NS), get_bloginfo('name')); ?>" href="<?php bloginfo('atom_url'); ?>" />
<?php endif; ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
remove_action('wp_head', 'wp_generator');
wp_enqueue_script('jquery');
if ( is_singular() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}
wp_head(); ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/script.js"></script>
</head>
<noframs><noscript><body <?php if(function_exists('body_class')) body_class(); ?>></noscript></noframs>
<div id="main">
    <div class="cleared reset-box"></div>
    <div class="header">
        <div class="header-position">
            <div class="header-wrapper">
                <div class="cleared reset-box"></div>
                <div class="header-inner">
                <div class="textblock"><a href="<?php echo home_url();?>" title="<?php echo get_bloginfo('name'); ?>" ><img src="<?php echo get_bloginfo('template_url') . theme_get_option('theme_header_logo') ; ?>" alt="<?php echo get_bloginfo('name'); ?>" > </a> </div>
                <div class="logo"><?php echo do_shortcode(theme_get_option('theme_header_content')); ?></div>
                </div>
            </div>
    	  </div>
    </div>
    <div class="cleared reset-box"></div>
    <div class="bar nav">
        <div class="nav-outer">
        <div class="nav-wrapper">
        <div class="nav-inner">
    	<?php 
    		echo theme_get_menu(array(
    				'source' => theme_get_option('theme_menu_source'),
    				'depth' => theme_get_option('theme_menu_depth'),
    				'menu' => 'primary-menu',
    				'class' => 'hmenu'	
    			)
    		);
    	?>
        </div>
        </div>
        </div>
    </div>
    <div class="cleared reset-box"></div>
    <div class="box sheet">
    	<div class="style:cleared">
					<div class="breadbox">
					<div class="breadcrumb">
					<?php the_breadcrumb();?>
					</div>
					</div>
					<?php if (is_home()) : ?>
					<div class="style:cleared"><div class="headerbottomads"> <?php if (theme_get_option('theme_header_bottom_ads') && theme_get_option('theme_show_header_bottom_ads')) {echo theme_get_option('theme_header_bottom_ads');} ?></div></div>
					<?php endif; ?>
		  </div>
        <div class="box-body sheet-body">