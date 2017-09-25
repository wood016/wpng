<?php get_template_part( 'header', get_post_format() ); ?> 
<img src="<?php bloginfo('template_url');?>/images/position.gif">
<?php if(function_exists('motheme_breadcrumb')) motheme_breadcrumb();?>  
<div style="height: 10px"></div>
<?php $options = get_option('mothemes_options'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<table cellspacing=0 cellpadding=0 width="100%">
  <tbody>
  <tr>
    <td width=600>
      <table class=commonlistarea border=0 cellspacing=1 cellpadding=5 width="100%">
        <tbody>
        <tr class=commonlisttitle>
          <td colspan=2><?php the_title(); ?></td></tr>
        <tr class=commonlistcell>
          <td width="13%">发布用户</td>
          <td><?php the_author_nickname();?></td></tr>
        <tr class=commonlistcell>
          <td>添加日期</td>
          <td><?php the_time('Y/m/d h:i:s'); ?></td></tr>
        <tr class=commonlistcell>
          <td>最后更新</td>
          <td><?php the_time('Y/m/d h:i:s'); ?></td></tr>
	<tr class="commonlistcell">
		<td>浏览次数</td>
		<td><?php echo motheme_the_views(); ?></td>
	</tr>
        <tr class=commonlistcell>
          <td>标　　签</td>
          <td><?php the_tags('', ' ', ''); ?></td></tr>
        <tr class=commonlistcell>
          <td>喜　　欢</td>
          <td><div class=bdlikebutton></div></td></tr>
        <tr class=commonlistcell>
          <td>分　　享</td>
          <td><?php echo $options['sharecode'];?></td>
        </tr></tbody></table></td>
    <td align=middle>
<?php if ($options['adbrief']) : ?>
<?php echo $options['adbrief']; ?>
<?php else :?>
 <img src="<?php bloginfo('template_url');?>/images/single_ads_300x250.jpg">
<?php endif; ?>
    </td></tr></tbody></table>
<?php if (get_post_meta($post->ID,"video_url",true)) : ?>
<div style="height: 10px"></div>
<table class=commonlistarea border=0 cellspacing=1 cellpadding=5 width="100%">
  <tbody>
  <tr class=commonlisttitle><td colspan=2>下载链接</td></tr>
  <tr class="commonlistcell"><td width="870"><span class="downlink"></span> <a href="<?php echo motheme_download_link(get_post_meta($post->ID,"video_url",true),'Test',''); ?>">下载地址 DOWNLOAD</a></td><td align="center" width="80"><span class="downtyle"></span></td>
  </tbody>
</table>
<?php endif; ?>
<div style="height: 10px"></div>
<div style="text-align: center; margin: auto; width: 960px; overflow: hidden">
<?php if ($options['adcontent']) : ?>
<?php echo $options['adcontent']; ?>
<?php else :?>
 <img src="<?php bloginfo('template_url');?>/images/single_ads_960x60.png">
<?php endif; ?>
</div>
<div style="height: 10px"></div><a name=summary></a>
<div class=menutag>
<li class=nowtag><a href="<?php the_permalink(); ?>#summary"><font color=#333>简 介</font></a></li>
<li><a href="<?php the_permalink(); ?>#comments"><font color=#ffffff>评 论</font></a></li></div>
<div class="pannelbody">
				
				
          <?php the_content('Read more...'); ?>
        
</div>
<!--user comment start-->
<div style="height: 10px"></div><a name=comments></a>
<div class=menutag>
<li><a href="<?php the_permalink(); ?>#summary"><font color=#ffffff>简 介</font></a></li>
<li class=nowtag><a href="<?php the_permalink(); ?>#comments"><font color=#333>评 论</font></a></li></div>
<div class=pannelbody>
<table cellspacing=0 cellpadding=0 width="100%">
  <tbody>
  <tr>
    <td width=720>
      <div class=ds-thread data-title="<?php the_title(); ?>">
      <?php comments_template(); ?>
      </div>
    </td>
    <td align=middle>
<?php if ($options['adcomment']) : ?>
<?php echo $options['adcomment']; ?>
<?php else :?>
 <img src="<?php bloginfo('template_url');?>/images/single_ads_120x300.gif">
<?php endif; ?>
      
    </td></tr>
  </tbody>
</table>
</div>
<div></div><!--user comment end-->
<div style="height: 10px"></div>
<?php endwhile;endif; ?>
<?php get_template_part( 'footer', get_post_format() ); ?>