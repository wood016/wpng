<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $options = get_option('mothemes_options'); ?>
<?php 
if ( is_single() || is_page() || is_search())  : 
foreach((get_the_category()) as $category) :
 $seo_catas .= ' '. $category->cat_name ;
 $seo_catas = trim($seo_catas);
endforeach;
if ( get_the_tags() ) :
foreach((get_the_tags()) as $tag) :
 $seo_tags .= ' '. $tag->name ;
 $seo_tags = trim($seo_catas);
endforeach;
endif;
 $seo_site_title = motheme_seo(' ',' | ', get_the_title() . ' ' . $seo_catas .' '. $options['keywords'].' '.get_bloginfo('name'));
 $seo_site_keywords = motheme_seo(' ',' | ',$seo_tags  .' '. $seo_catas .' '. $options['keywords'].' '.get_bloginfo('name'));
 $seo_site_desc = motheme_seo(' ',' | ', $seo_catas .' '. $options['desc'] .' '. get_bloginfo('description').' '.get_bloginfo('name'));
endif ?>
<?php 
if ( is_category() || is_tag()  ) : 
 $seo_cata = single_cat_title('',false); 
 $seo_site_title = motheme_seo(' ',' | ',$seo_cata .' '. $options['desc'].' '.get_bloginfo('description').' '.get_bloginfo('name')); 
 $seo_site_keywords = motheme_seo(' ',' | ',$seo_cata .' '. $options['keywords'].' '.get_bloginfo('name') );
 $seo_site_desc = motheme_seo(' ',' | ',$seo_cata .' '. $options['desc'] .' '. get_bloginfo('description').' '.get_bloginfo('name'));
endif; ?>
<?php 
if ( is_home() ) : 
 $seo_site_title = motheme_seo(' ',' | ',get_bloginfo('description').' '.$options['keywords'] .' '. get_bloginfo('name') ) ; 
 $seo_site_keywords = motheme_seo(' ',' | ',$options['keywords'] .' '. get_bloginfo('description').' '.get_bloginfo('name') );
 $seo_site_desc = motheme_seo(' ',' | ',$options['keywords'] .' '. $options['desc'] .' '. get_bloginfo('description').' '.get_bloginfo('name'));
endif; ?>

<title><?php echo $seo_site_title; ?></title>
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<meta name="keywords" content="<?php echo $seo_site_keywords;?>">
<meta name="description" content="<?php echo $seo_site_desc; ?>">
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/style.css">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" type=image/x-icon href="<?php bloginfo('template_url');?>/images/favicon.ico">
<script language=javascript type=text/javascript src="<?php bloginfo('template_url');?>/scripts/global.js"></script>
<script language=javascript type=text/javascript src="<?php bloginfo('template_url');?>/scripts/m.js"></script>
<meta name=generator content="mshtml 8.00.7601.17514">
<?php if ($options['head-analysis']) echo $options['head-analysis']; ?>
</head>
<body>
<div class="header">
<div class="logo"><a class="ed2000logo" title="<?php bloginfo('name'); ?>" href="<?php bloginfo('siteurl'); ?>"></a></div>
<div class="banner">
<div style="height:20px;"></div>
<div style="clear:both;"></div>
<?php if ($options['admain']) : ?>
<?php  echo $options['admain']; ?>
<?php else :?>
 <img src="<?php bloginfo('template_url');?>/images/header_ads_640x60.jpg">
<?php endif; ?>
</div>
</div>
<div class="topmenu">
<ul>
  <li><a class="thisclass" href="<?php bloginfo('siteurl'); ?>"><?php _e("首页", 'ed2k'); ?></a></li>
<?php 
	$menuParameters = array(
	  'theme_location'=>'primary',
		'container'	=> false,
		'echo'	=> false,
		'items_wrap' => '%3$s',
		'depth'	=> 1,
	    );  
	  echo str_replace('</a>','</a></li>',str_replace('<a','<li><a',strip_tags(wp_nav_menu( $menuParameters ), '<a>' )));
?>
</ul>
</div>
<div style="height:5px;"></div>
<?php if ($options['admenubottom']) : ?>
<?php  echo $options['admenubottom']; ?>
<?php else :?>
 <img src="<?php bloginfo('template_url');?>/images/single_ads_960x60.png">
<?php endif; ?>
<div style="height:5px;"></div>
<?php if ( function_exists ('motheme_record_views') && (is_single() || is_page())) motheme_record_views(); ?>
