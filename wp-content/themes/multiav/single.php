<?php 

/**
 *
 * single.php
 *
 * The single post template. Used when a single post is queried.
 * 
 */	

get_header(); ?>
<div class="layout-wrapper">
    <div class="content-layout">
        <div class="content-layout-row">
            <div class="layout-cell content">
			<?php get_sidebar('top');  ?>
			<?php 
				if (have_posts()){
					
					while (have_posts())  
					{
					/* Display navigation to next/previous posts when applicable */
					if (theme_get_option('theme_top_single_navigation')) {
						theme_page_navigation(
							array(
								'next_link' => theme_get_previous_post_link('&laquo; %link'),
								'prev_link' => theme_get_next_post_link('%link &raquo;')
							)
						);
					}

						the_post();
						get_template_part('content', 'single');
					
					/* Display navigation to next/previous posts when applicable */
					if (theme_get_option('theme_bottom_single_navigation')) {
						theme_page_navigation(
							array(
								'next_link' => theme_get_previous_post_link('&laquo; %link'),
								'prev_link' => theme_get_next_post_link('%link &raquo;')
							)
						);
					}
											
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
            <div class="layout-cell sidebar1">
              <?php get_sidebar('default'); ?>
              <div class="cleared"></div>
            </div>
        </div>
    </div>
</div>
<div class="cleared"></div>
<?php get_footer(); ?>