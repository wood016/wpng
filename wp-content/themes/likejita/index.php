<?php get_template_part( 'header', get_post_format() ); ?>
<?php $options = get_option('mothemes_options'); ?>
<div class=left>
<!--统计 start-->
<div class="leftparta">
<dl>
  <dt><a href="#">站内公告</a></dt>
<?php if ($options['sitebbs']) : ?>
<?php $sitebbs = explode("\n",$options['sitebbs']) ;?>
<?php foreach ($sitebbs as $key => $value) : ?>
<?php if (trim($value)) : ?>
<dd><span><?php echo $value; ?></span></dd>
<?php endif ?>
<?php endforeach ?>
<?php else : ?>
  <dd><span>暂无公告</span></dd>
<?php endif; ?>
</dl>
</div>
<!--统计 end-->
<div style="height: 10px"></div>
<div class="share">
<dl>
  <dt>搜索</dt>
  <form onsubmit="if(this.keyword.value.length<1){alert('请输入搜索关键词');return false;}else if(this.keyword[0].checked){window.open('<?php bloginfo('siteurl'); ?>?s='+encodeuricomponent(this.keyword.value));return false;}" method="get" name="keyword" action=<?php bloginfo('siteurl'); ?> target=_blank>
  <dd>关键字：<input size=18 type="text" name="keyword"></dd>
  <dd>引　擎：<input id="duoci" value="duoci" checked type="radio"  name="s"><label for="duoci">百度</label> <input id=<?php bloginfo('siteurl'); ?> value=<?php bloginfo('siteurl'); ?> type=radio name="s"><label for=<?php bloginfo('siteurl'); ?>>站内</label></dd>
  <dd style="text-align: center"><input value=" 搜索 " type=submit></dd></form></dl></div>
<div style="height: 10px"></div>
<div class="share">
<dl>
  <dt>分享</dt>
  <dd>
<?php echo $options['indexshare'];?>
  </dd>
</dl>
</div>
</div>
<!--right start-->
<!--最新 start-->
<div id=最新资源 class="righta hslice">
<h4 class=entry-title><a title="最新资源" href="">最新资源</a></h4>
<ul class=entry-content>
<?php $posts = get_posts( 'numberposts=13' ); ?>
<?php if( $posts ) : $postnum = 1;?>
<?php foreach( $posts as $post ) : ?>
<?php if ($postnum <= 3) : ?>
<span class="homethum"><a title="<?php the_title() ?>" href="<?php the_permalink() ?>"><img src="<?php echo motheme_get_first_img();?>" height=110px width=110px alt="<?php the_title() ?>"></a></span>
<?php else : ?>
<?php setup_postdata( $post ); $motheme_catas = (get_the_category($post->ID)); $motheme_cata = $motheme_catas[0];?>
<li><label><b><a href="<?php echo get_category_link($motheme_cata->term_id); ?>" target="_blank" class="c999">[<?php echo $motheme_cata->cat_name ;?>]</a></b><a href="<?php the_permalink() ?>" target="_blank" title="<?php the_title(); ?>"> <?php the_title(); ?></a></label><span class="date"><?php $post_date = (get_the_time('m-d') == date('m-d')) ? '<font color=red>'.get_the_time('m-d').'</font>' : get_the_time('m-d'); echo $post_date; ?></span></li>
<?php endif; ?>
<?php $postnum++;endforeach; ?>
<?php endif; ?>
</ul>
</div>
<!--最新 end-->
<!--热门资源 start-->
<div id=热门资源 class="rightb hslice">
<h4 class=entry-title><a title="" href="">热门资源</a></h4>
<ul class=entry-content>
<?php if ( function_exists ('motheme_the_views')) {$querystring = 'meta_key=views&orderby=meta_value_num&order=desc&showposts=13';}  else { $querystring = 'orderby=rand&showposts=13';}
query_posts($querystring); 
$postnum = 1;
while (have_posts()) : the_post(); ?>
<?php if ($postnum <= 3) : ?>
<span class="homethum"><a title="<?php the_title() ?>" href="<?php the_permalink() ?>"><img src="<?php echo motheme_get_first_img();?>" alt="<?php the_title() ?>"></a></span>
<?php else : ?>
<?php $motheme_catas = (get_the_category($post->ID)); $motheme_cata = $motheme_catas[0];?>
<li><label><b><a href="<?php echo get_category_link($motheme_cata->term_id); ?>" target="_blank" class="c999">[<?php echo $motheme_cata->cat_name ;?>]</a></b><a href="<?php the_permalink() ?>" target="_blank" title="<?php the_title(); ?>"> <?php the_title(); ?></a></label><span class="date"><?php $post_date = (get_the_time('m-d') == date('m-d')) ? '<font color=red>'.get_the_time('m-d').'</font>' : get_the_time('m-d'); echo $post_date; ?></span></li>
<?php endif; ?>
<?php $postnum++;endwhile;?>
</ul>
</div>
<!--热门资源 end-->
<!--right end-->
<div style="height: 10px"></div>
<div style="text-align: center; margin: auto; width: 960px; overflow: hidden">
<?php if ($options['adindexbanner']) : ?>
<?php echo $options['adindexbanner']; ?>
<?php else :?>
 <img src="<?php bloginfo('template_url');?>/images/index_960x90.jpg">
<?php endif; ?>
</div>
<div style="height: 10px"></div><!--left start-->
<div style="height: 1280px" class=left><!--热点资源 start-->
<div class="leftparta">
<dl>
  <dt title="">本周热点</dt>
<?php if ( function_exists ('motheme_the_views')) {$querystring = 'meta_key=views&orderby=meta_value_num&order=desc&showposts=23';}  else { $querystring = 'orderby=rand&showposts=23';}
query_posts($querystring); 
while (have_posts()) : the_post();?>
<dd><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></dd>
<?php endwhile;?>
</dl></div>
<div style="height: 10px"></div>
<div style="text-align: center; margin: auto; width: 160px; overflow: hidden">
<?php if ($options['adindexvertical']) : ?>
<?php echo $options['adindexvertical']; ?>
<?php else :?>
 <img src="<?php bloginfo('template_url');?>/images/index_160x600.jpg">
<?php endif; ?>
</div>
<!--热点资源 end-->
</div>
<!--left end-->

<!--right start-->
<?php
if ($options['homezone_cata_ids']) {
$args = explode(',' , $options['homezone_cata_ids']);
$categories = array();
foreach($args as $arg) {
$catearg = array('include' => $arg);
$categories_tmp = get_categories($catearg);
$categories[] = $categories_tmp[0];
}
//$args = array('include' => $options['homezone_cata_ids']);
} else {
$args=array('orderby' => 'term_id','order' => 'ASC');
$categories=get_categories($args);
}
//$categories=get_categories($args);
$catanum = 1;
//print_r($categories);
foreach($categories as $category) :?>
<div id=<?php echo $category->name; ?> class="<?php $cataclass=(($catanum % 2) <> 0) ? 'righta hslice' : 'rightb hslice' ; echo $cataclass; ?>">
<h4 class="entry-title"><a title="" href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></h4>
<ul class="entry-content">
<?php $posts = get_posts( 'cat='.$category->term_id.'&numberposts=13' ); ?>
<?php if( $posts ) : ?>
<?php foreach( $posts as $post ) : setup_postdata( $post ); $motheme_catas = (get_the_category($post->ID)); $motheme_cata = $motheme_catas[0];?>
<li><label><a href="<?php the_permalink() ?>" target="_blank" title="<?php the_title(); ?>"> <?php the_title(); ?></a></label><span class="date"><?php $post_date = (get_the_time('m-d') == date('m-d')) ? '<font color=red>'.get_the_time('m-d').'</font>' : get_the_time('m-d'); echo $post_date; ?></span></li>
<?php endforeach; ?>
<?php endif; ?>
</ul>
</div>
<?php $catanum++;	endforeach; ?>
<!--right end-->
<?php get_template_part( 'footer', get_post_format() ); ?>