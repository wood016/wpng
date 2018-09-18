<div class="cleared"></div>
        </div>
  <div class="clear"></div>
  <?php if (is_home()) : ?>
    <div class="links">
	<h3 class="title"><strong><?php echo __('Apply Link',THEME_NS);?></strong></h3>
	<ul>
		<?php echo  wp_list_bookmarks('title_li=&title_before=&title_after=&categorize=0&orderby=id&order=DESC&category=&echo=0'); ?>
		<div class="clear"></div>
	</ul>
	<div class="clear"></div>
    </div>
    </div>
  <?php endif ;?>
    <div class="footer">
        <div class="footer-body">
        <?php get_sidebar('footer'); ?>
            <div class="footer-center">
                <div class="footer-wrapper">
                    <div class="footer-text">
                        <?php  echo do_shortcode(theme_get_option('theme_footer_content')); ?>
                        <div class="cleared"></div>
                        <div class="footer" id="footer">
	<p> <?php printf(__('Copyright&nbsp;&#169;&nbsp;2011-2012&nbsp;',THEME_NS )); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a> <?php printf(__('&nbsp;All Rights Reserved!', THEME_NS)); ?> <br> <?php printf(__('Theme By', THEME_NS)); ?> <a href="http://www.hotxxxooo.com" target="_blank">www.hotxxxooo.com</a></p>
	<p><?php printf(__('Mailto WebMaster : %s, replace # as @', THEME_NS), str_replace("@"," # ",get_bloginfo('admin_email')));?></p>
</div>
                    </div>
                </div>
            </div>
            <div class="cleared"></div>
        </div>
    </div>
    <div class="cleared"></div>
</div>
    <div id="wp-footer">
	        <?php wp_footer(); ?>
	        <!-- <?php printf(__('%d queries. %s seconds.', THEME_NS), get_num_queries(), timer_stop(0, 3)); ?> -->
    </div>
<div style="display:none;">
<noscript></body></noscript>
</html>
</div>