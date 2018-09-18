<?php
// $style = 'post' or 'block' or 'vmenu' or 'simple'
function theme_wrapper($style, $args){
	$func_name = "theme_{$style}_wrapper";
	if (function_exists($func_name)) {
		call_user_func($func_name, $args);
	} else {
		theme_block_wrapper($args);
	}
}

function theme_post_wrapper($args = '') {
	$args = wp_parse_args($args, 
		array(
			'id' => '',
			'class' => '',
			'title' => '',
			'heading' => 'h2',
			'thumbnail' => '',
			'before' => '',
			'content' => '',
			'after' => ''
		)
	);
	extract($args);
	if (theme_is_empty_html($title) && theme_is_empty_html($content)) return;
	if ($id) {
		$id = ' id="' . $id . '"';
	}
	if ($class) {
		$class = ' ' . $class; 
	}
	?>
<div class="box post">
	    <div class="box-body post-body">
	            <?php
	                if (!theme_is_empty_html($title)){
	                    echo '<'.$heading.' class="postheader">'.$title.'</'.$heading.'>';
	                }
	                 ob_start();
	                    echo $before;
	                $meta = ob_get_clean();    
	                if (strlen($meta) > 0) {
	                	 if (is_single()) {$meta = str_replace('<br/>',theme_get_option('theme_metadata_separator'), $meta);}
	                    echo '<div class="postmetadataheader">'.$meta.'</div>';
	                }
	                

	                ?>
<div class="cleared"></div>
	                <div class="postcontent">
	                    <?php echo $thumbnail . $content; ?>
	                </div>
	                <div class="cleared"></div>
	                <?php
	                ob_start();
	                    echo $after;
	                $meta = ob_get_clean();    
	                if (strlen($meta) > 0) {
	                	if (is_single()) {$meta = str_replace(theme_get_option('theme_metadata_separator'),'<br/>', $meta);}
	                    echo '<div class="postmetadatafooter">'.$meta.'</div>';
	                }
	                
	            ?>
			<div class="cleared"></div>
    </div>
	</div>
<?php
}
function theme_multithum_wrapper($args = '') {
	$args = wp_parse_args($args, 
		array(
			'id' => '',
			'class' => '',
			'title' => '',
			'heading' => 'h2',
			'thumbnail' => '',
			'before' => '',
			'content' => '',
			'after' => ''
		)
	);
	extract($args);
	if (theme_is_empty_html($title) && theme_is_empty_html($content)) return;
	if ($id) {
		$id = ' id="' . $id . '"';
	}
	if ($class) {
		$class = ' ' . $class; 
	}
	?>
<div class="multibox">
	            <?php
	                 ob_start();
	                    echo $before;
	                $meta = ob_get_clean();    
	                if (strlen($meta) > 0) {
	                	 if (is_single()) {$meta = str_replace('<br/>',theme_get_option('theme_metadata_separator'), $meta);}
	                    echo '<div class="postmetadataheader">'.$meta.'</div>';
	                }
	                ?>
	                <div class="subbox">
	                <div class="subcontent">
	                    <?php echo $thumbnail; ?>
	                </div>
	                <div class="subtitle">
	                <?php
	                if (!theme_is_empty_html($title)){
	                    echo $title;
	                }
	                ?>
	                </div>
	                </div>
	                <div class="cleared"></div>
	                <?php
	                ob_start();
	                    echo $after;
	                $meta = ob_get_clean();    
	                if (strlen($meta) > 0) {
	                	if (is_single()) {$meta = str_replace(theme_get_option('theme_metadata_separator'),'<br/>', $meta);}
	                    echo '<div class="postmetadatafooter">'.$meta.'</div>';
	                }
	                
	            ?>
			<div class="cleared"></div>
	</div>
	
	<?php
}
function theme_multicata_wrapper($args = '') {
	$args = wp_parse_args($args, 
		array(
/*			'id' => '',
			'class' => '',
			'title' => '',
			'heading' => 'h2',
			'thumbnail' => '',
			'before' => '',
			'content' => '',
			'after' => '',
*/
			'cataid' => '',
			'postnum' => ''
		)
	);
	extract($args);
	$cataids = explode(',',$cataid);
	if (empty($postnum)) {$postnum = 20;}
	foreach ( $cataids as $num => $subcataid ) {
 /*   $args = array(
    'showposts' => 20,
    'cat' => $subcataid,
    'post__not_in'   => $do_not_duplicate
    );
    query_posts($args);
    while (have_posts()) : the_post();
    endwhile;
    */
  ?>
  <div class="cleared"></div>
  <div class="home_cata_<?php echo $num % 3 ;?>">
  <h2><a href="<?php echo get_category_link($subcataid);?> "><?php echo get_the_category_by_ID($subcataid); ?></a></h2>
  </div>
  <?php
   			query_posts( array(
				'showposts' => $postnum,
				'cat' => $subcataid
				)
			);
   while (have_posts()) : the_post(); 
   //single_cat_title();
   ?>
   <div class="multibox">
	 <div class="subbox">
	 <div class="subcontent">
	 <?php echo theme_get_post_thumbnail(); ?>
	 </div>
	 <div class="subtitle">
	 	<a href="<?php echo the_permalink(); ?>" rel="bookmark" title="<?php echo $post->post_title ;?>"><b style="font-size:15px"><?php echo get_the_title();?></b></a>
	 </div>
	 </div>
	 </div>
	 <?php
   endwhile;
 }
}
function theme_simple_wrapper($args = '') {
	$args = wp_parse_args($args, 
		array(
			'id' => '',
			'class' => '',
			'title' => '',
			'heading' => 'div',
			'content' => '',
		)
	);
	extract($args);
	if (theme_is_empty_html($title) && theme_is_empty_html($content)) return;
	if ($id) {
		$id = ' id="' . $id . '"';
	}
	if ($class) {
		$class = ' ' . $class; 
	}
	echo "<div class=\"widget{$class}\"{$id}>";
	if ( !theme_is_empty_html($title)) echo '<'.$heading.' class="widget-title">' . $title . '</'.$heading.'>';
	echo '<div class="widget-content">' . $content . '</div>';
	echo '</div>';
}

function theme_block_wrapper($args) {
	$args = wp_parse_args($args, 
		array(
			'id' => '',
			'class' => '',
			'title' => '',
			'heading' => 'div',
			'content' => '',
		)
	);
	extract($args);
	if (theme_is_empty_html($title) && theme_is_empty_html($content)) return;
	if ($id) {
		$id = ' id="' . $id . '"';
	}
	if ($class) {
		$class = ' ' . $class; 
	}

	$begin = <<<EOL
<div class="box block{$class}"{$id}>
    <div class="box-body block-body">
EOL;
	$begin_title  = <<<EOL
<div class="bar blockheader">
    <$heading class="t">
EOL;
	$end_title = <<<EOL
</$heading>
</div>
EOL;
	$begin_content = <<<EOL
<div class="box blockcontent">
    <div class="box-body blockcontent-body">
EOL;
	$end_content = <<<EOL
		<div class="cleared"></div>
    </div>
</div>
EOL;
	$end = <<<EOL
		<div class="cleared"></div>
    </div>
</div>
EOL;
	echo $begin;
	if ($begin_title && $end_title && !theme_is_empty_html($title)) {
		echo $begin_title . $title . $end_title;
	}
	echo $begin_content;
	echo $content;
	echo $end_content;
	echo $end;	
}

function theme_vmenu_wrapper($args) {
	$args = wp_parse_args($args, 
		array(
			'id' => '',
			'class' => '',
			'title' => '',
			'heading' => 'div',
			'content' => '',
		)
	);
	extract($args);
	if (theme_is_empty_html($title) && theme_is_empty_html($content)) return;
	if ($id) {
		$id = ' id="' . $id . '"';
	}
	if ($class) {
		$class = ' ' . $class; 
	}

	$begin = <<<EOL
<div class="box vmenublock{$class}"{$id}>
    <div class="box-body vmenublock-body">
EOL;
	$begin_title  = <<<EOL
<div class="bar vmenublockheader">
    <$heading class="t">
EOL;
	$end_title = <<<EOL
</$heading>
</div>
EOL;
	$begin_content = <<<EOL
<div class="box vmenublockcontent">
    <div class="box-body vmenublockcontent-body">
EOL;
	$end_content = <<<EOL
		<div class="cleared"></div>
    </div>
</div>
EOL;
	$end = <<<EOL
		<div class="cleared"></div>
    </div>
</div>
EOL;
	echo $begin;
	if ($begin_title && $end_title && !theme_is_empty_html($title)) {
		echo $begin_title . $title . $end_title;
	}
	echo $begin_content;
	echo $content;
	echo $end_content;
	echo $end;	
}