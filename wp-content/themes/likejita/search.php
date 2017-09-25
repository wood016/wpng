<?php get_template_part( 'header', get_post_format() ); ?> 
<div class=topsearch>
<div class=title></div>
<div class=inpbox>
<form method="get" name=searchform action="<?php bloginfo('siteurl'); ?>">关键字：<input class="searchtxt" size=15  name="s" type="text" value="" ><input value=" 搜索 " type=submit> </form>
</div></div>
<div style="height: 10px"></div>
<div style="float: left"><img src="<?php bloginfo('template_url');?>/images/position.gif"> 
 <?php if(function_exists('motheme_breadcrumb')) motheme_breadcrumb();?>  
</div>
</div>
<div style="clear: both"></div>
</div>
<div class="right_content">
<?php if(!have_posts()) : ?>
<?php query_posts('caller_get_posts=1&posts_per_page=5'); ?>
<?php endif; ?>
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
  	<span class="listspan0">[<?php echo the_category('],[') ;?>] <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <?php $postviews = motheme_the_views(); if ( $postviews > 50) : ?><img alt="<?php the_title(); ?>" src="<?php bloginfo('template_url');?>/images/hot.gif"> <?php endif;?></span>
    <span class="listspan1"><?php the_time('Y-m-d')?></span>
    <span class="listspan2"><?php the_time('Y-m-d h:i:s')?></span>
    <span class="listspan3"><?php echo motheme_the_views()?></span>
   </div>
<?php endwhile; ?>


</div>
<div class="pagenav"><?php wp_pagenavi();?></div>
</div>
<?php get_template_part( 'footer', get_post_format() ); ?>