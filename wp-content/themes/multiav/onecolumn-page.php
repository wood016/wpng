<?php
/*
Template Name: One Column
*/
?>
<?php get_header(); ?>
<div class="layout-wrapper">
    <div class="content-layout">
        <div class="content-layout-row">
            <div class="layout-cell content">
			<?php get_sidebar('top'); ?>
			<?php 
				if(have_posts()) {

					/* Start the Loop */ 
					while (have_posts()) {
						the_post();
						get_template_part('content', 'page');
						/* Display comments */
						if ( theme_get_option('theme_allow_comments')) {
							comments_template();
						}
					}
					
				
				} else {
				
					 theme_404_content();
					 
				} 
		    ?>
			<?php get_sidebar('bottom'); ?>
              <div class="cleared"></div>
            </div>
        </div>
    </div>
</div>
<div class="cleared"></div>
<?php get_footer(); ?>