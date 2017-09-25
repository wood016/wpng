<?php 
/**
 * left sider help center widget class
 */
class mothemes_widget_helpcenter extends WP_Widget {
  function mothemes_widget_helpcenter() {
      $widget_ops = array('description' => __('Help Center'));
      $this->WP_Widget('mothemes_widget_helpcenter','M-'.__('Help Center','MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
    extract($args);
    $nav_name = strip_tags($instance['nav_name']);
    //$limit = $limit ? $limit : 10;
    $title = $instance['title'] ? strip_tags($instance['title']) : __('Help Center','MoThemes');
?>
			<ul id="help_list" class="column clearfix">
				<li>
				<h2><?php echo $title;?></h2>
				<ul>
				<?php
					$menuParameters = array(
					'theme_location'=> 'lefthelpcenter',
					'container'	=> false,
					'container_class'	=> false,
					'menu_class' => false,
					'menu_id' => false,
				  //'menu' => strip_tags($instance['nav_name']),
					'link_before' => '<i>&#160;</i>',
					'echo'	=> true,
					'items_wrap' => '%3$s',
					'walker' => new themeslug_walker_nav_menu(),
					'depth'	=> 2,
					);
					if(function_exists('wp_nav_menu')) {
					wp_nav_menu($menuParameters);
					}
					?>
				</ul>
			  </li>
			</ul>
<?php
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['nav_name'] = strip_tags($new_instance['nav_name']);
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('nav_name' => ''), array('title' => ''));
        $instance['nav_name'] = strip_tags($new_instance['nav_name']);
        $title = strip_tags($instance['title']);
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?></label><br />
        <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:', 'MoThemes'); ?></label><br />
        <select class="widefat" id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
<?php 
				foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
				}
?>
				</select>
				</p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
  }
}
 add_action('widgets_init', 'mothemes_widget_helpcenter');
 function mothemes_widget_helpcenter() {
    register_widget('mothemes_widget_helpcenter');
 }

/**
 * Left Menus widget class
 */
class mothemes_widget_leftmenus extends WP_Widget {
  function mothemes_widget_leftmenus() {
      $widget_ops = array('description' => __('Left Menus'));
      $this->WP_Widget('mothemes_widget_leftmenus','M-'.__('Left Menus','MoThemes'), $widget_ops);
    }
    function widget($args, $instance) {
    //global $post;
    extract($args);
    $limit = strip_tags($instance['limit']);
    $limit = $limit ? $limit : 10;
    $title = $instance['title'] ? strip_tags($instance['title']) : __('Left Menus','MoThemes');
?>
		<ul class="column2 mt10 clearfix">
			<li>
				<h2><?php echo $title;?></h2>
				<ul class="about_yyw">
<?php
					$menuParameters = array(
					'theme_location'=>'leftmenu',
					'container'	=> false,
					'echo'	=> false,
					'items_wrap' => '%3$s',
					'depth'	=> 1,
					);
					$menu_regex = '#<li class="(.*)\-([0-9]+)"><a href="(.*)">(.*)</a></li>#';
					$menu_contents = wp_nav_menu( $menuParameters );
					preg_match_all($menu_regex, $menu_contents , $match_all);
					foreach ($match_all[0] as $key => $value) {
					  $menu_content .= preg_replace($menu_regex,'<li id="left_navi${2}"><a href="${3}"><i>&#160;</i>${4}</a></li>', $value);
				  }
					echo $menu_content;
					?>
				</ul>
			</li>
		</ul>
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
        $instance = wp_parse_args((array) $instance, array('nav_name' => ''), array('title' => ''));
        $instance['nav_name'] = strip_tags($new_instance['nav_name']);
        $title = strip_tags($instance['title']);
?>
         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('widget title&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('limit&#58;', 'MoThemes');?><input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
  }
}
 add_action('widgets_init', 'mothemes_widget_leftmenus_init');
 function mothemes_widget_leftmenus_init() {
    register_widget('mothemes_widget_leftmenus');
 }
?>