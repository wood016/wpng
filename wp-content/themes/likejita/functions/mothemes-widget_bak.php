<?php

//////////////////////////////////////////////////////////

class mothemes_similar_images extends WP_Widget {
    function mothemes_similar_images() {
        $widget_ops = array('description' => __('Similar images', 'MoThemes'));
        $this->WP_Widget('mothemes_similar_images','L-'.__('Similar images', 'MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
    $title = $instance['title'] ? strip_tags($instance['title']) : __('Similar images', 'MoThemes');
        $limit = strip_tags($instance['limit']);
?>
<div class="widgets">
  <h3><?php echo $title;?></h3>
  <div class="widgets-similar clx">
    <?php
    $post_num = $limit ? $limit : 12;
    $exclude_id = $post->ID;
    $posttags = get_the_tags(); $i = 0;
    if ( $posttags ) {
   $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ',';
   $args = array('post_status' => 'publish', 'tag__in' => explode(',', $tags), 'post__not_in' => explode(',', $exclude_id), 'ignore_sticky_posts' => 1, 'orderby' => 'rand', 'posts_per_page' => $post_num);
   query_posts($args);
   while( have_posts() ) { the_post(); $class = ($i+1)%3==0 ? 'class="similar similar-third"':'class="similar"';?>
   <a <?php echo $class;?> href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php post_sidebar_thumbnail(78); ?></a>
   <?php
     $exclude_id .= ',' . $post->ID; $i ++;
   } wp_reset_query();
    }
    if ( $i < $post_num ) {
   $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
   $args = array('category__in' => explode(',', $cats), 'post__not_in' => explode(',', $exclude_id), 'ignore_sticky_posts' => 1, 'orderby' => 'rand', 'posts_per_page' => $post_num - $i); query_posts($args);
   while( have_posts() ) { the_post();  $class = ($i+1)%3==0 ? 'class="similar similar-third"':'class="similar"';?>
   <a <?php echo $class;?> href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php post_sidebar_thumbnail(78); ?></a>
   <?php $i++;
   } wp_reset_query();
    }
    if ( $i  == 0 ) _e('no similar posts', 'MoThemes');
    ?>
  </div>
</div>
<?php
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['limit'] = strip_tags($new_instance['limit']);
     $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('limit' => ''), array('title' => ''));
        $limit = strip_tags($instance['limit']);
    $title = strip_tags($instance['title']);
?>

         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Post number&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'mothemes_similar_images_init');
function mothemes_similar_images_init() {
    register_widget('mothemes_similar_images');
}

//////////////////////////////////////////////////////////

class mothemes_widget2 extends WP_Widget {
    function mothemes_widget2() {
        $widget_ops = array('description' => __('popular tags', 'MoThemes'));
        $this->WP_Widget('mothemes_widget2','L-'.__('popular tags', 'MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $limit = strip_tags($instance['limit']);
    $limit = $limit ? $limit : 30;
    $title = $instance['title'] ? strip_tags($instance['title']) : __('popular tags', 'MoThemes');
?>
  <div class="widgets">
    <h3><?php echo $title;?></h3>
    <div id="pin-tags" class="clx">
      <?php wp_tag_cloud("smallest=10&largest=10&orderby=count&order=DESC&number=$limit"); ?>
    </div>
  </div>
<?php
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['limit'] = strip_tags($new_instance['limit']);
    $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('limit' => ''));
        $limit = strip_tags($instance['limit']);
    $title = strip_tags($instance['title']);
?>
         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Post number&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'mothemes_widget2_init');
function mothemes_widget2_init() {
    register_widget('mothemes_widget2');
}

//////////////////////////////////////////////////////////

class mothemes_widget3 extends WP_Widget {
    function mothemes_widget3() {
        $widget_ops = array('description' => __('Add for sidebar', 'MoThemes'));
        $this->WP_Widget('mothemes_widget3','L-'.__('Add for sidebar', 'MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $html = $instance['html'];
    $title = $instance['title'] ? strip_tags($instance['title']) : __('Add for sidebar', 'MoThemes');;
?>
  <div class="widgets">
    <h3><?php echo $title;?></h3>
    <div class="widgets-as"><?php echo $html;?></div>
  </div>
<?php
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['html'] = $new_instance['html'];
    $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('html' => ''), array('title'=> ''));
        $html = $instance['html'];
    $title = strip_tags($instance['title']);
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('html'); ?>"><?php _e('Ad html code&#58;', 'MoThemes');?><br /><textarea id="<?php echo $this->get_field_id('html'); ?>" name="<?php echo $this->get_field_name('html'); ?>" class="widefat" type="text"><?php echo $html; ?></textarea></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'mothemes_widget3_init');
function mothemes_widget3_init() {
    register_widget('mothemes_widget3');
}

//////////////////////////////////////////////////////////

class mothemes_widget4 extends WP_Widget {
    function mothemes_widget4() {
        $widget_ops = array('description' => __('Most popular images', 'MoThemes'));
        $this->WP_Widget('mothemes_widget4','L-'.__('Most popular images', 'MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $limit = strip_tags($instance['limit']);
    $limit = $limit ? $limit : 12;
    $title = $instance['title'] ? strip_tags($instance['title']) : __('Most popular images', 'MoThemes');
?>
  <div class="widgets">
      <h3><?php echo $title;?></h3>
      <ul class="widgets-popular widgets-similar clx">
        <?php
          $j=0;
          $paged = 1;
          $args2 = array(
            'meta_key' => 'views',
            'orderby'   => 'meta_value_num',
            'showposts'=> $limit,
            'paged' => $paged,
            'ignore_sticky_posts' => 1,
            'order' => DESC
          );
          query_posts($args2);
          while( have_posts() ) { the_post();  $class = ($j+1)%3==0 ? 'class="similar similar-third"':'class="similar"';?>
          <a <?php echo $class;?> href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php post_sidebar_thumbnail(78); ?></a>
          <?php $j++;
          } wp_reset_query();
        ?>
      </ul>
  </div>
<?php
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['limit'] = strip_tags($new_instance['limit']);
    $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('limit' => ''));
        $limit = strip_tags($instance['limit']);
    $title = strip_tags($instance['title']);
?>
         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Post number&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'mothemes_widget4_init');
function mothemes_widget4_init() {
    register_widget('mothemes_widget4');
}

//////////////////////////////////////////////////////////
class mothemes_widget6 extends WP_Widget {
    function mothemes_widget6() {
        $widget_ops = array('description' => __('Author info', 'MoThemes'));
        $this->WP_Widget('mothemes_widget6','L-'.__('Author info', 'MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
    $title = $instance['title'] ? strip_tags($instance['title']) : __('Author info', 'MoThemes');
        $limit = strip_tags($instance['limit']);
?>

    <?php if( is_home() || is_search() || is_archive() || is_page('views')  || is_page('video') || is_page('image')){?>
      <div class="widgets">
      <?php if ( is_user_logged_in() ) {
        global $current_user;
        get_currentuserinfo();
        ?>

        <div class="widget-author clx">
          <?php echo get_avatar( $current_user->ID , 40 ); ?>
          <div class="main-desp">
            <h4><?php echo $current_user->display_name; ?></h4>
            <p><?php echo $current_user->user_description; ?></p>
          </div>
        </div>
        <?php if( $current_user->user_level>0 ) {?>
        <div class="author-option clx">
          <div class="gap">
            <a href="<?php echo get_page_link_by_title('profile');?>"><span><?php _e('Edit my profile', 'MoThemes');?></span></a>
          </div>
          <a href="<?php /*new_link('text');*/?>"><?php _e('New text','MoThemes'); ?></a>
          <a href="<?php /*new_link('image');*/?>"><?php _e('New image','MoThemes'); ?></a>
          <a href="<?php /*new_link('video');*/?>"><?php _e('New video','MoThemes'); ?></a>
        </div>
        <?php }?>
      <?php }else{?>
        <h3><?php _e('Login now','MoThemes'); ?></h3>
        <div class="widget-login clx">
          <a href="<?php bloginfo('url'); ?>/wp-login.php" class="loginin" title="<?php _e("login in", "LoveVideo");?>"><?php _e("login in", "LoveVideo");?></a>
          <a href="<?php bloginfo('url'); ?>/wp-login.php?action=register" class="signup" title="<?php _e("sign up", "LoveVideo");?>"><?php _e("sign up", "LoveVideo");?></a>
        </div>
      <?php }?>
      </div>
    <?php }else if(is_single()){?>
      <div class="widgets">
        <div class="widget-author clx">
          <?php echo get_avatar( get_the_author_id() , 40 ); ?>
          <div class="main-desp">
            <h4><?php _e('Author&#58', 'MoThemes');?><?php the_author_posts_link(); ?></h4>
            <p><?php echo get_the_author_meta('user_description');?></p>
          </div>
        </div>
      </div>
    <?php }?>

<?php
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
     $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('limit' => ''), array('title' => ''));
    $title = strip_tags($instance['title']);
?>

         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'mothemes_widget6_init');
function mothemes_widget6_init() {
    register_widget('mothemes_widget6');
}



//////////////////////////////////////////////////////////
class mothemes_widget8 extends WP_Widget {
    function mothemes_widget8() {
        $widget_ops = array('description' => __('SNS', 'MoThemes'));
        $this->WP_Widget('mothemes_widget8','L-'.__('SNS', 'MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
    global $post;
        extract($args);
    $title = $instance['title'] ? strip_tags($instance['title']) : __('SNS', 'MoThemes');

?>
  <div id="widgets-sns" class="widgets">
    <h3><?php echo $title;?></h3>
    <ul class="clx">
      <?php $array = array(
          "rss" => __("RSS", 'MoThemes'),
          "tsina"=>  __("tsina", 'MoThemes'),
          "tqq" => __("tqq", 'MoThemes'),
          "renren"=>  __("renren", 'MoThemes'),
          "douban" => __("douban", 'MoThemes'),
          "kaixin"=>  __("kaixin", 'MoThemes'),
          );
        $options = get_option('mothemes_options');
        foreach($array as $value => $X){
          if($value=="rss") {?>
            <a href="<?php if($options['rss']!=""){echo $options['rss'];}else{bloginfo('rss2_url');} ?>" class="sns-rss" title="<?php _e('RSS','MoThemes');?>"></a>
          <?php }else if($options[$value]){?>
            <a href="<?php echo $options[$value];?>" class="sns-<?php echo $value;?>" title="<?php echo $X;?>"></a>
          <?php }
        }
      ?>
    </ul>
  </div>
<?php
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
     $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('limit' => ''), array('title' => ''));
    $title = strip_tags($instance['title']);
?>

         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'mothemes_widget8_init');
function mothemes_widget8_init() {
    register_widget('mothemes_widget8');
}



//////////////////////////////////////////////////////////
class mothemes_widget9 extends WP_Widget {
    function mothemes_widget9() {
        $widget_ops = array('description' => __('Search', 'MoThemes'));
        $this->WP_Widget('mothemes_widget9','L-'.__('Search', 'MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
    global $post;
        extract($args);
    $title = $instance['title'] ? strip_tags($instance['title']) : __('Search', 'MoThemes');

?>
  <div id="widgets-sns" class="widgets">
    <h3><?php echo $title;?></h3>
    <div id="search" class="clearfix">
      <form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
        <input type="text" class="search-input" name="s" id="s" placeholder="<?php _e('Search', 'MoThemes');?>">
        <input type="submit" class="search-submit" value="<?php _e('Search', 'MoThemes');?>">
      </form>
    </div>
  </div>
<?php
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
     $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('limit' => ''), array('title' => ''));
    $title = strip_tags($instance['title']);
?>

         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'mothemes_widget9_init');
function mothemes_widget9_init() {
    register_widget('mothemes_widget9');
}


//////////////////////////////////////////////////////////
class mothemes_widget10 extends WP_Widget {
    function mothemes_widget10() {
        $widget_ops = array('description' => __('Categories'));
        $this->WP_Widget('mothemes_widget10','L-'.__('Categories'), $widget_ops);
    }
    function widget($args, $instance) {
    //global $post;
    extract($args);
    $limit = strip_tags($instance['limit']);
    $limit = $limit ? $limit : 0;
    $title = $instance['title'] ? strip_tags($instance['title']) : __('Categories');
?>
  <div class="widgets">
    <h3><?php echo $title;?></h3>
    <div id="catagory-tags" class="catagory-clx">
      <?php $args=array('orderby' => 'term_id','order' => 'ASC', 'number' => $limit);
			$categories=get_categories($args);
		  foreach($categories as $category) {?>
		  <a href="<?php echo get_category_link($category->term_id) ?>"><span></span><?php echo $category->name; ?></a>
		  <?php } ?>
    </div>
  </div>
<?php
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['limit'] = strip_tags($new_instance['limit']);
     $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('limit' => ''), array('title' => ''));
        $instance['limit'] = strip_tags($new_instance['limit']);
    $title = strip_tags($instance['title']);
?>
         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Post number&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'mothemes_widget10_init');
function mothemes_widget10_init() {
    register_widget('mothemes_widget10');
}

/**
 * Archives widget class
 */
class mothemes_widget11 extends WP_Widget {

  function mothemes_widget11() {
      $widget_ops = array('description' => __('A monthly archive of your site&#8217;s Posts.'));
      $this->WP_Widget('mothemes_widget11','L-'.__('Archives'), $widget_ops);
    }

	function widget( $args, $instance ) {
		extract($args);
		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Archives') : $instance['title'], $instance, $this->id_base);
?>
<div class="widgets">
<?php
		if ( $title )
		echo '<h3>' . $title . '</h3>';
		if ( $d ) {
?>
		<select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> <option value=""><?php echo esc_attr(__('Select Month')); ?></option> <?php wp_get_archives(apply_filters('widget_archives_dropdown_args', array('type' => 'monthly', 'format' => 'option', 'show_post_count' => $c))); ?> </select>
<?php
		} else {
?>
  <div id="archives-tags" class="archives-clx">
		<?php $archives_result = wp_get_archives(apply_filters('widget_archives_args', array('type' => 'monthly', 'show_post_count' => $c, 'format' => 'custom', 'before' => '', 'after' =>'', 'echo' => false))); 
		echo preg_replace('/<a(.*?)href=["\'](.*?)["\'](.*?)>/i','<a href="$2"><span></span>',$archives_result);
		?>
  </div>
<?php
		}

?></div>
<?php }

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = $new_instance['count'] ? 1 : 0;
		$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$title = strip_tags($instance['title']);
		$count = $instance['count'] ? 'checked="checked"' : '';
		$dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown'); ?></label>
			<br/>
			<input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts'); ?></label>
		</p>
<?php
	}
}
add_action('widgets_init', 'mothemes_widget11_init');
function mothemes_widget11_init() {
    register_widget('mothemes_widget11');
}


/**
 * rank posts widget class
 */
class mothemes_widget12 extends WP_Widget {
  function mothemes_widget12() {
      $widget_ops = array('description' => __('rank of your site&#8217;s Posts.'));
      $this->WP_Widget('mothemes_widget12','L-'.__('RankPosts','MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
    //global $post;
    extract($args);
    $limit = strip_tags($instance['limit']);
    $limit = $limit ? $limit : 10;
    $title = $instance['title'] ? strip_tags($instance['title']) : __('RankPosts','MoThemes');
?>

<div class="widgets">
<?php if ( $title )	echo '<h3>' . $title . '</h3>';?>
 <div id="rankpost-tags" class="rankpost-clx">
       <ol class="rank-list tab-panel">
           <?php if (function_exists('theme_get_most_viewed')): ?>
           <ul>
             <?php theme_get_most_viewed($limit); ?>
           </ul>
           <?php endif; ?>
       </ol>
<?php if (mothemes_paihang_ad()) : ?>
   <div class="textwidget">
     <div id="sslider">
       <div id="sslider-wrap">
         <div id="sslider-main">
           <?php mothemes_paihang_ad();?>
         </div>
       </div>
       <span id="sslider-prev">&lt;</span><span id="sslider-next">&gt;</span>
     </div>
   </div>
<?php endif;?>
</div>

<?php
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['limit'] = strip_tags($new_instance['limit']);
     $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('limit' => ''), array('title' => ''));
        $instance['limit'] = strip_tags($new_instance['limit']);
    $title = strip_tags($instance['title']);
?>
         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Post number&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
  }
 }
}
 add_action('widgets_init', 'mothemes_widget12_init');
 function mothemes_widget12_init() {
    register_widget('mothemes_widget12');
 }
?>