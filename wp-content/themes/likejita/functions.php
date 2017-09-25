<?php

define( "THEME_NAME", "MoThemes" );
load_theme_textdomain( THEME_NAME, TEMPLATEPATH."/languages" );

require( dirname(__FILE__) . '/functions/metaboxclass.php' );
require( dirname(__FILE__) . '/functions/metabox.php' );

function mothemes_widgets( )
{
		register_sidebar( array(
				"name" => __( "left sidebar help", "MoThemes" ),
				"id" => "left_sidebar_help",
				"description" => __( "left sidebar help", "MoThemes" ),
				"before_widget" => "<ul id=\"help_list\" class=\"column clearfix\"><li>",
				"after_widget" => "</li><li>",
				"before_title" => "<h2>",
				"after_title" => "</h2>"
		) );
		register_sidebar( array(
				"name" => __( "sidebar1fixed", "MoThemes" ),
				"id" => "sidebar1fixed",
				"description" => __( "sidebar1fixed", "MoThemes" ),
				"before_widget" => "<div id=\"%1\$s\" class=\"widgets %2\$s\">",
				"after_widget" => "</div>",
				"before_title" => "<h3>",
				"after_title" => "</h3>"
		) );
		register_sidebar( array(
				"name" => __( "sidebar2", "MoThemes" ),
				"id" => "sidebar2",
				"description" => __( "sidebar2", "MoThemes" ),
				"before_widget" => "<div id=\"%1\$s\" class=\"widgets %2\$s\">",
				"after_widget" => "</div>",
				"before_title" => "<h3>",
				"after_title" => "</h3>"
		) );
		register_sidebar( array(
				"name" => __( "sidebar2fixed", "MoThemes" ),
				"id" => "sidebar2fixed",
				"description" => __( "sidebar2fixed", "MoThemes" ),
				"before_widget" => "<div id=\"%1\$s\" class=\"widgets %2\$s\">",
				"after_widget" => "</div>",
				"before_title" => "<h3>",
				"after_title" => "</h3>"
		) );
}
add_action( "widgets_init", "mothemes_widgets" );

require( dirname(__FILE__) . '/functions/mothemes-widget.php' );
require( dirname(__FILE__) . '/functions/mothemes-admin.php' );

if ( function_exists( "register_nav_menus" ) )
{
		register_nav_menus( array( "primary" => "首页菜单" ) );
		register_nav_menus( array( "leftmenu" => "左栏菜单" ) );
		register_nav_menus( array( "lefthelpcenter" => "左栏帮助中心" ) );
		register_nav_menus( array( "leftsingle" => "内容页菜单" ) );
		register_nav_menus( array( "footermenu" => "页脚菜单" ) );
}

if ( !function_exists( "motheme_breadcrumb" ) ){
function motheme_breadcrumb() {
?>
<?php _e("现在的位置：", '111'); ?><a href="<?php bloginfo('url'); ?>"><?php _e("首页",'111'); ?></a> &raquo; 
<?php
if( is_single() ){
$categorys = get_the_category();
$category = $categorys[0];
echo( get_category_parents($category->term_id, true, ' &raquo; ') );
the_title( '<span>', '</span>' );
} elseif ( is_page() ){
the_title( '<span>', '</span>' );
} elseif ( is_category() ){
single_cat_title();
} elseif ( is_tag() ){
single_tag_title();
} elseif ( is_day() ){
the_time('Y年Fj日');
} elseif ( is_month() ){
the_time('Y年F');
} elseif ( is_year() ){
the_time('Y年');
} elseif ( is_search() ){
echo $_GET['s'].' 的搜索结果';
}
}
}

if ( !function_exists( "motheme_get_first_img" ) ){
  function motheme_get_first_img() {
  global $post;
  preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.bmp|\.jpeg|\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i", stripcslashes($post->post_content), $matches);
  $the_img = $matches [1][0];
  if(empty($the_img)){
  	$the_img = bloginfo('template_url').'/images/nothumb.png';
  }
  return $the_img;
  }
}

if ( !function_exists( "motheme_baidushare" ) ){
	function motheme_baidushare() {
?>
<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone"></a><a href="#" class="bds_tsina" data-cmd="tsina"></a><a href="#" class="bds_tqq" data-cmd="tqq"></a><a href="#" class="bds_renren" data-cmd="renren"></a><a href="#" class="bds_weixin" data-cmd="weixin"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<?php }
}

if ( !function_exists( "motheme_seo" ) ){
function motheme_seo ( $old_splitword, $new_splitword, $string ) {
	$string = preg_replace('#'.$old_splitword.'{2,}#',$old_splitword,$string);
return implode($new_splitword,array_filter(array_unique(explode($old_splitword,str_replace('|',' ',$string)))));
}
}
/////////

if ( !function_exists( "motheme_download_link" ) ){
function motheme_download_link ( $orig_link, $downname, $type ) {
if ( strlen($orig_link) == 40 ) { $download = 'magnet:?xt=urn:btih:'.strtoupper($orig_link).'&dn='.$downname; }
if ( preg_match('#^http:#',$orig_link) ) { $download = $orig_link; }
return $download;
}
}

class themeslug_walker_nav_menu extends Walker_Nav_Menu {
  
// add classes to ul sub-menus
function start_lvl( &$output, $depth = 0, $args = array() ) {
    // depth dependent classes
    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
    $classes = array(
        'style="display: none;"',
        /*( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
        ( $display_depth >=2 ? 'style="display: none;"' : '' ),
        'menu-depth-' . $display_depth*/
        );
    $class_names = implode( ' ', $classes );
  
    // build html
    $output .= "\n" . $indent . '<ul '. $class_names . '>' . "\n";
}
  
// add main/sub classes to li's and links
 function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    global $wp_query;
    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
  
    // depth dependent classes
    $depth_classes = array(
        /*( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
        'menu-item-depth-' . $depth*/
    );
    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
  
    // passed classes
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
  
    // build html
    $output .= ( $depth == 0 ? $indent . '<li>' : $indent . '<li id="left_navi'. $item->ID . '">'  );
  
    // link attributes
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    /*$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';*/
    
    $outputformat = ( $depth == 0 ? '<h3 class="">%3$s%4$s%5$s</h3>' : '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s' );
    $item_output = sprintf( $outputformat,
        $args->before,
        $attributes,
        $args->link_before,
        apply_filters( 'the_title', $item->title, $item->ID ),
        $args->link_after,
        $args->after
    );
  
    // build html
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    //$output = ( $depth == 0 ? '<h3 class="">'.$output.'</h3>' : $output );
}
}

class footer_walker_nav_menu extends Walker_Nav_Menu {

 function start_lvl( &$output, $depth = 0, $args = array() ) {
    // depth dependent classes
    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
    $classes = array(
        //'style="display: none;"',
        /*( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
        ( $display_depth >=2 ? 'style="display: none;"' : '' ),
        'menu-depth-' . $display_depth*/
        );
    $class_names = implode( ' ', $classes );
  
    // build html
    $output .=  $indent. "\n";
 }
 function end_lvl( &$output, $item, $depth = 0, $args = array() ) {
		$output.= "</dl>\n";
 }
 
// add main/sub classes to li's and links
 function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    global $wp_query;
    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
  
    // depth dependent classes
    $depth_classes = array(
        /*( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
        'menu-item-depth-' . $depth*/
    );
    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
  
    // passed classes
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
  
    // build html
    $output .= ( $depth == 0 ? $indent : $indent );
  
    // link attributes
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    /*$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';*/
    
    $outputformat = ( $depth == 0 ? '<dl><dt>%3$s%4$s%5$s</dt>' : '<dd><a%2$s>%3$s%4$s%5$s</a></dd>' );
    $item_output = sprintf( $outputformat,
        $args->before,
        $attributes,
        $args->link_before,
        apply_filters( 'the_title', $item->title, $item->ID ),
        $args->link_after,
        $args->after
    );
  
    // build html
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    //$output .= $item_output;
    //$output = ( $depth == 0 ? '<h3 class="">'.$output.'</h3>' : $output );
}

 function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "\n";
 }

}

function wp_pagenavi() {  

//先申明两个全局变量  

global $wp_query,$wp_rewrite;  

//判断当前页面  

$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current= 1;  

$pagination=array(  

'base'=> @add_query_arg('paged','%#%'),  

'format'=>'',  

'total'=>$wp_query->max_num_pages,  

'current'=>$current,  

'show_all'=> false,  

'type'=>'plain',  

'end_size'=>'1',//在最后和最前至少显示多少个页码数，这里最后最前至少显示“1” 页的意思  

'mid_size'=>'4',//在最后和最前之间至少显示多少个页码数

'prev_text'=>'上一页',  

'next_text'=>'下一页'

);  

if($wp_rewrite->using_permalinks() )  

$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) .'page/%#%/','paged');  

if( !empty($wp_query->query_vars['s']) )  

$pagination['add_args'] =array('s'=>get_query_var('s'));  

echo paginate_links($pagination);  

} 

//记录文章点击次数
if ( ! function_exists('motheme_record_views') ) {
function motheme_record_views() {
	global $post;
	$postID = $post->ID;
  $count_key = 'views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
}

//查看文章点击次数
if ( ! function_exists('motheme_the_views') ) {
function motheme_the_views(){
global $post;
$postID = $post->ID;
    $count_key = 'views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        echo "0";
    }
    return $count;
}
}
?>
