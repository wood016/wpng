<!--footer start--> 
<?php $options = get_option('mothemes_options'); ?>
<div class=clr></div>
<div style="height: 10px"></div>
<div class=footer>
	
<?php 
	$menuParameters = array(
	  'theme_location'=>'footermenu',
		'container'	=> false,
		'echo'	=> false,
		'items_wrap' => '%3$s',
		'depth'	=> 1,
	    );  
	  echo str_replace('</a>','</a>',str_replace('<a','<a class="nav_link"',strip_tags(wp_nav_menu( $menuParameters ), '<a>' )));
?>
<a onclick="javascript:window.external.addfavorite('<?php bloginfo('siteurl'); ?>','<?php bloginfo('name'); ?>');">收藏本站</a> 
<br>Copyright © <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved
<?php if ( $options['analysis'] ) : ?><br><span id="cnzz"><?php echo $options['analysis'];?></span><?php endif;?>
</div>
</body>
</html>