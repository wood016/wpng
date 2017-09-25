<?php get_template_part( 'header', get_post_format() ); ?> 
<div class=topsearch>
<div class=title></div>
<div class=inpbox>
<form method="get" name=searchform action="<?php bloginfo('siteurl'); ?>">关键字：<input class="searchtxt" size=15  name="s" type="text" value="<?php the_search_query(); ?>" ><input value=" 搜索 " type=submit> </form>
</div></div>
<div style="height: 10px"></div>
<div style="float: left"><img src="<?php bloginfo('template_url');?>/images/position.gif"> 
 <?php if(function_exists('motheme_breadcrumb')) motheme_breadcrumb();?>  
<?php $theme_cata = get_the_category();?>
<div style="text-align: right; width: 870px; padding-right: 10px"><a href="<?php echo get_category_link($theme_cata[0]->term_id);?>">热门资源</a></div>
<div style="text-align: right; width: 880px">
<?php 
$sub_catas = get_categories("child_of=".$theme_cata[0]->term_id."&depth=0&hide_empty=0&title_li=");
foreach ($sub_catas as $subcata) : ?>
<a class="subcategory" href="<?php echo get_category_link($subcata->term_id);?>"><?php echo $subcata->name;?></a>
<?php endforeach;?>
</div>
</div>

<div style="width: 70px; height: 70px;padding-right: 0px; float: right"><img alt="<?php echo $theme_cata[0]->name; ?>" src="<?php bloginfo('template_url');?>/images/books.jpg"></div>
<div style="height: 70px"></div>

</div>
<div class="right_content">
<?php global $query_string; query_posts($query_string.'&caller_get_posts=1&posts_per_page=15'); ?>
<?php if(have_posts()) : ?>
<div class="commonlistarea">
<div class="commonlisttitle">资源列表</div>
<div class="commonlistcell">
	<span class="listspan0">标题</span> 
	<span class="listspan1">发布日期</span>
	<span class="listspan2">最后更新</span>
	<span class="listspan3">下载</span>
</div>
<?php while(have_posts()) : the_post(); ?>
   <div class="commonlistcell">
  	<span class="listspan0">[<?php echo the_category('] [') ;?>] <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <?php if (get_the_time('Y-m-d') == date('Y-m-d')) : ?><img src="<?php bloginfo('template_url');?>/images/new.gif" alt="最新资源"> <?php endif; ?> <?php $postviews = motheme_the_views(); if ( $postviews > 10) : ?><img alt="<?php the_title(); ?>" src="<?php bloginfo('template_url');?>/images/hot.gif"> <?php endif;?></span>
    <span class="listspan1"><?php the_time('Y-m-d')?></span>
    <span class="listspan2"><?php the_time('Y-m-d h:i:s')?></span>
    <span class="listspan3"><?php echo motheme_the_views()?></span>
   </div>
<?php endwhile; ?>
<?php endif; ?>

</div>
<div class="pagenav"><?php wp_pagenavi();?></div>
</div>
<?php get_template_part( 'footer', get_post_format() ); ?>