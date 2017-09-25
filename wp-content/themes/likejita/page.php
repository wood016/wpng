<?php get_template_part( 'header', get_post_format() ); ?> 
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/styles/single.css">
<img src="<?php bloginfo('template_url');?>/images/position.gif">
<?php if(function_exists('motheme_breadcrumb')) motheme_breadcrumb();?>  
<div style="height: 10px"></div>

<div class="page">
<?php if (have_posts()) : the_post(); ?>
<div style="text-align:center;font-size:12pt; font-weight:bold;"><?php the_title(); ?></div>
<hr />
<div style="text-align:center;"><?php bloginfo('siteurl'); ?>　浏览次数：<?php echo motheme_the_views(); ?>　最后更新：<?php the_time('Y/m/d h:i:s'); ?></div><div style="height:10px;"></div>
<div class="pagecontent">
  <?php the_content(); ?>
</div>
<?php endif; ?>
</div>


<?php get_template_part( 'footer', get_post_format() ); ?>