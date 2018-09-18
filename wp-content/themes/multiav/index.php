<?php get_header(); ?>
<div class="layout-wrapper">
    <div class="content-layout">
        <div class="content-layout-row">
            <div class="layout-cell content">
			<?php get_sidebar('top'); ?>
			<?php
				if(have_posts()) {

					/* Display navigation to next/previous pages when applicable */
					if ( theme_get_option('theme_' . (theme_is_home() ? 'home_' : '') . 'top_posts_navigation' ) ) {
						theme_page_navigation();
					}

					/* Start the Loop */
					while (have_posts()) {
						the_post();
						get_template_part('content', get_post_format());
					}


				} else {
					 theme_404_content();
				}
		    ?>
      	<?php
      	if( theme_get_option('theme_homepage_display_cataid') ) {
      	theme_multicata_wrapper(
      		array(
      				'cataid' => theme_get_option('theme_homepage_display_cataid')
      		)
      	);
      	//echo theme_get_option('theme_homepage_display_cataid');
        }?>
      	<?php
					/* Display navigation to next/previous pages when applicable */
					if (theme_get_option('theme_bottom_posts_navigation')) {
						 ?>
						 <div class="cleared"></div>
						 <?php
						 theme_page_navigation();

					}
      	?>
			<?php get_sidebar('bottom'); ?>
              <div class="cleared"></div>
            </div>
            <div class="layout-cell sidebar1">
              <?php get_sidebar('default'); ?>
              <div class="cleared"></div>
            </div>
        </div>
    </div>
</div>
<div class="cleared"></div>
<?php get_footer(); ?>